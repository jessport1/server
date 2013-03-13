<?php
/**
 * @package Scheduler
 * @subpackage TagResolver
 */
class KAsyncTagResolve extends KPeriodicWorker
{
	/* (non-PHPdoc)
	 * @see KBatchBase::getJobType()
	 */
	protected function getJobType() {
		return self::getType();
		
	}

	/* (non-PHPdoc)
	 * @see KBatchBase::run()
	 */
	public function run($jobs = null) 
	{
		KalturaLog::info("Running tag resolver");
		$tagPlugin = KalturaTagSearchClientPlugin::get($this->kClient);
		$tagPlugin->tag->resolveTags();
	}
	
	/**
	 * @return int
	 * @throws Exception
	 */
	public static function getType()
	{
		return KalturaBatchJobType::TAG_RESOLVE;
	}

	
}