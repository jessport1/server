<?php
/**
 * @package Scheduler
 * @subpackage Delete
 */
class KDeletingCategoryUserEngine extends KDeletingEngine
{
	/* (non-PHPdoc)
	 * @see KDeletingEngine::delete()
	 */
	protected function delete(KalturaFilter $filter, $shouldUpdate)
	{
		return $this->deleteCategoryUsers($filter, $shouldUpdate);
	}
	
	/**
	 * @param KalturaCategoryUserFilter $filter The filter should return the list of category users that need to be deleted
	 * @return int the number of deleted category users
	 */
	protected function deleteCategoryUsers(KalturaCategoryUserFilter $filter)
	{
		$filter->orderBy = KalturaCategoryUserOrderBy::CREATED_AT_ASC;
		
		$categoryUsersList = $this->client->categoryUser->list($filter, $this->pager);
		if(!count($categoryUsersList->objects))
			return 0;
			
		$this->client->startMultiRequest();
		foreach($categoryUsersList->objects as $categoryUser)
		{
			/* @var $categoryUser KalturaCategoryUser */
			$this->client->categoryUser->delete($categoryUser->userId, $categoryUser->categoryId);
		}
		$results = $this->client->doMultiRequest();
		foreach($results as $result)
			if($result instanceof Exception)
				throw $result;
				
		return count($results);
	}
}
