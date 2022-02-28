<?php

namespace App\Service\Character;

use DateTime;
use App\Entity\Character;
use App\Form\CharacterType;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\CharacterRepository;
use LogicException;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;
use Symfony\Component\Validator\Validator\ValidatorInterface;

use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class CharacterService implements CharacterServiceInterface
{

  public function __construct(
    private EntityManagerInterface $em,
    private CharacterRepository $characterRepository,
    private FormFactoryInterface $formFactory,
    private ValidatorInterface $validator
  ) {
  }

  /**
   * {inheritdoc}
   */
  public function getAll()
  {
    $charactersFinal = array();
    $characters = $this->characterRepository->findAll();
    foreach ($characters as $character) {
      $charactersFinal[] = $character->toArray();
    }

    return $charactersFinal;
  }

  /**
   * {inheritdoc}
   */
  public function create(string $data)
  {
    //Use with {"kind":"Dame","name":"Eldalótë","surname":"Fleur elfique","caste":"Elfe","knowledge":"Arts","intelligence":120,"life":12,"image":"/images/eldalote.jpg"}
    $character = new Character();
    $character
      ->setIdentifier(hash('sha1', uniqid()))
      ->setCreation(new DateTime())
      ->setModification(new DateTime());

    $this->submit($character, CharacterType::class, $data);
    $this->isEntityFilled($character);

    $this->em->persist($character);
    $this->em->flush();

    return $character;
  }

  /**
   * {@inheritdoc}
   */
  public function isEntityFilled(Character $character)
  {
    $errors = $this->validator->validate($character);
    if (count($errors) > 0) {
      throw new UnprocessableEntityHttpException((string) $errors . ' Missing data for Entity -> ' . json_encode($character->toArray()));
    }
  }

  /**
   * {@inheritdoc}
   */
  public function submit(Character $character, $formName, $data)
  {
    $dataArray = is_array($data) ? $data : json_decode($data, true);

    //Bad array
    if (null !== $data && !is_array($dataArray)) {
      throw new UnprocessableEntityHttpException('Submitted data is not an array -> ' . $data);
    }

    //Submits form
    $form = $this->formFactory->create($formName, $character, ['csrf_protection' => false]);
    $form->submit($dataArray, false); //With false, only submitted fields are validated

    //Gets errors
    $errors = $form->getErrors();
    foreach ($errors as $error) {
      throw new LogicException('Error ' . get_class($error->getCause()) . ' --> ' . $error->getMessageTemplate() . ' ' . json_encode($error->getMessageParameters()));
    }
  }

  public function modify(string $data, Character $character)
  {
    $this->submit($character, CharacterType::class, $data);
    $this->isEntityFilled($character);
    $character
      ->setModification(new DateTime());

    $this->em->persist($character);
    $this->em->flush();

    return $character;
  }

  public function delete(Character $character)
  {
    $this->em->remove($character);

    $this->em->flush();

    return true;
  }

  /**
   * {@inheritdoc}
   */
  public function getImages(int $number, ?string $kind = null)
  {
    $folder = __DIR__ . '/../../../public/images/';

    $finder = new Finder();
    $finder
      ->files()
      ->in($folder)
      ->notPath('/cartes/')
      ->sortByName();

    if (null !== $kind) {
      $finder->path('/' . $kind . '/');
    }

    $images = array();

    foreach ($finder as $file) {
      $images[] = '/images/' . $file->getPathname();
    }

    shuffle($images);
    return array_slice($images, 0, $number, true);
  }

  public function getImagesKind(int $number, string $kind)
  {
    return $this->getImages($number, $kind);
  }

  /**
   * {@inheritdoc}
   */
  public function serializeJson($data)
  {
    $encoders = new JsonEncoder();
    $defaultContext = [AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER => function ($data) {
      return $data->getIdentifier();
    },];
    $normalizers = new ObjectNormalizer(null, null, null, null, null, null, $defaultContext);
    $serializer = new Serializer([new DateTimeNormalizer(), $normalizers], [$encoders]);
    return $serializer->serialize($data, 'json');
  }
}
