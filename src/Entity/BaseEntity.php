<?php


namespace App\Entity;


use App\Constant\Status;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

abstract class BaseEntity
{
    /**
     * @ORM\Column(type="string", length=50)
     */
    protected $status;

    public function __construct()
    {
        $this->setStatus(Status::ACTIVE);
    }

    /**
     * @return array
     */
    abstract public function toArray(): array;


    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return object
     */
    public function toObject(): object
    {
        return (object)$this->toArray();
    }

    /**
     * @return string
     */
    public function toJson(): string
    {
        return json_encode($this->toArray());
    }

    /**
     * @param $data
     * @param array $filter
     * @return BaseEntity
     */
    public function setArrayValueToField(array $data, array $filter = []) : BaseEntity
    {
        foreach ($data as $key => $value) {
            if (!in_array($key, $filter) && (isset($value) && $value !== '')) {
                $this->$key = $value;
            }
        }

        return $this;
    }

    public function serialize($value)
    {
        $encoders = [new JsonEncoder()]; // If no need for XmlEncoder
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);

        // Serialize your object in Json
        $jsonObject = $serializer->serialize($value, 'json', [
            'circular_reference_handler' => function ($object) {
                return $object->getId();
            }
        ]);
        return $jsonObject;
    }
}