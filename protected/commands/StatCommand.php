<?php
class StatCommand extends CConsoleCommand
{

	public function init() 
	{
		ini_set('max_execution_time', 3600*12);
		return parent::init();
	}

	public function actionProject()
	{	
		$time 			= strtotime('-1 day');
		$dayTimeFrom 	= strtotime(date('Y-m-d 00:00:00', $time));
		$monthTimeFrom 	= strtotime(date('Y-m-01 00:00:00', $time));
		$timeTo 		= strtotime(date('Y-m-d 23:59:58', $time));
		
		$criteria=new CDbCriteria;
		$criteria->condition = "create_time >= {$dayTimeFrom} AND create_time <= {$timeTo}";
		
		$model = new ProjectStat;
		$model->total_day = Project::model()->count($criteria);

		$criteria=new CDbCriteria;
		$criteria->condition = "create_time >= {$monthTimeFrom} AND create_time <= {$timeTo}";
		$model->total_month = Project::model()->count($criteria);
		
		$criteria=new CDbCriteria;
		$criteria->condition = "create_time <= {$timeTo}";
		$model->total = Project::model()->count($criteria);
		
		$model->date = date('Y-m-d', $time);
		$model->save();
		
	}
	
	public function actionSet()
	{	
		$time = time();
		$projects = Project::model()->findAll();
		foreach ($projects as $project) {
			$project->create_time = $time;
			$project->save(false);
			
			echo "{$project->id} {$project->create_time} \n";
			
			$time-= 60*60*24;
		}
		
	}
	
}