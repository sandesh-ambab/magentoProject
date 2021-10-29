<?php 

namespace Ambab\EMImodule\Model\Api\Data;

interface EmidetailsInterface
{
    const BANK_ID = 'id';
    const BANK_NAME = 'bank_name';

    public function getId();

    public function getBankName();

    public function setId($id);

    public function setBankName($bank_name);
}