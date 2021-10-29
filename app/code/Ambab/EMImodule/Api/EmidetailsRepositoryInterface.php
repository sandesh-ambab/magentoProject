<?php
namespace Ambab\EMImodule\Api;

interface EmidetailsRepositoryInterface
{
	public function save(\Ambab\EMImodule\Api\Data\EmidetailsInterface $bank);

    public function getById($bankId);

    public function delete(\Ambab\EMImodule\Api\Data\EmidetailsInterface $bank);

    public function deleteById($bankId);
}
?>
