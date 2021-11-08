<?php 

namespace Ambab\EMImodule\Api\Data;

interface EmidetailsInterface
{
    const BANK_ID = 'id';
    const BANK_NAME = 'bank_name';
    const MONTH = 'month';
    const BANK_ROI = 'roi';

    public function getId();

    public function getBankName();

    public function getMonth();

    public function getBankRoi();
  
    public function setId($id);

    public function setBankName($bank_name);

    public function setMonth($month);

    public function setBankRoi($roi);
}