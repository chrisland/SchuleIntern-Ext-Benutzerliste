<?php
/**
 *
 */
class extUserlistModelMember
{

    /**
     * @var data []
     */
    private $data = [];
    private $user = false;


    /**
     * Constructor
     * @param $data
     */
    public function __construct($data = false, $user = false)
    {
        if (!$data) {
            $data = $this->data;
        }
        if ($user) {
            $this->user = $user;
        }
        $this->setData($data);
    }

    /**
     * @return data
     */
    public function setData($data = [])
    {
        $this->data = $data;
        return $this->getData();
    }

    /**
     * @return data
     */
    public function getData() {
        return $this->data;
    }

    /**
     * Getter
     */
    public function getID() {
        return $this->data['id'];
    }
    public function getToggle() {
        return $this->data['toggle'];
    }
    public function getInfo() {
        return $this->data['info'];
    }

    public function getCollection($full = false) {

        $collection = [
            "id" => $this->getID(),
            "toggle" => $this->getToggle(),
            "info" => $this->getInfo(),
        ];
        if ($this->user) {
            $user = $this->user->getCollection();
            $collection['vorname'] = $user['vorname'];
            $collection['nachname'] = $user['nachname'];
            $collection['name'] = $user['name'];
            $collection['type'] = $user['type'];
        }

        return $collection;
    }






}