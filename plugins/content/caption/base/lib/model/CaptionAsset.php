<?php
/**
 * Subclass for representing a row from the 'asset' table, used for caption_assets
 *
 * @package plugins.caption
 * @subpackage model
 */ 
class CaptionAsset extends asset
{
	const CUSTOM_DATA_FIELD_LANGUAGE = "language";
	const CUSTOM_DATA_FIELD_DEFAULT = "default";
	const CUSTOM_DATA_FIELD_LABEL = "label";

	/* (non-PHPdoc)
	 * @see Baseasset::applyDefaultValues()
	 */
	public function applyDefaultValues()
	{
		parent::applyDefaultValues();
		$this->setType(CaptionPlugin::getAssetTypeCoreValue(CaptionAssetType::CAPTION));
	}

	public function getLanguage()		{return $this->getFromCustomData(self::CUSTOM_DATA_FIELD_LANGUAGE);}
	public function getDefault()		{return $this->getFromCustomData(self::CUSTOM_DATA_FIELD_DEFAULT);}
	public function getLabel()			{return $this->getFromCustomData(self::CUSTOM_DATA_FIELD_LABEL);}

	public function setLanguage($v)		{$this->putInCustomData(self::CUSTOM_DATA_FIELD_LANGUAGE, $v);}
	public function setDefault($v)		{$this->putInCustomData(self::CUSTOM_DATA_FIELD_DEFAULT, (bool)$v);}
	public function setLabel($v)		{$this->putInCustomData(self::CUSTOM_DATA_FIELD_LABEL, $v);}
	
	protected function getFinalDownloadUrlPathWithoutKs()
	{
		$finalPath = '/api_v3/index.php/service/caption_captionAsset/action/serve';
		$finalPath .= '/captionAssetId/' . $this->getId();
		
		return $finalPath;
	}
	
	public function setFromAssetParams($dbAssetParams)
	{
		parent::setFromAssetParams($dbAssetParams);
		
		$this->setLanguage($dbAssetParams->getLanguage());
		$this->setLabel($dbAssetParams->getLabel());
	}
}