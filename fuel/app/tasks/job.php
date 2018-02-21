<?php

namespace Fuel\Tasks;

use Fuel\Core\DB;
use Fuel\Core\Log;

class Job
{
	public function clearFlag()
	{
		$where = '
			WHERE is_conscription = 1 AND
			(
				conscription_end_date < CURRENT_DATE OR (
					conscription_end_date IS NULL AND
					date_add(updated_at, interval 7 day) < NOW()
				)
			)
		';

		$sql = '
			SELECT job_id, is_conscription, conscription_start_date, conscription_end_date, updated_at
			FROM job
		' . $where;

		foreach (DB::query($sql)->execute()->as_array() as $row)
		{
			Log::warning('clear job.is_conscription: ' . json_encode($row));
			DB::query('UPDATE job SET is_conscription = 0 ' . $where)->execute();
		}

		$where = '
			WHERE is_pickup = 1 AND
			(
				pickup_end_date < CURRENT_DATE OR (
					pickup_end_date IS NULL AND
					date_add(updated_at, interval 7 day) < NOW()
				)
			)
		';

		$sql = '
			SELECT job_id, is_pickup, pickup_start_date, pickup_end_date, updated_at
			FROM job
		' . $where;

		foreach (DB::query($sql)->execute()->as_array() as $row)
		{
			Log::warning('clear job.is_pickup: ' . json_encode($row));
			DB::query('UPDATE job SET is_pickup = 0 ' . $where)->execute();
		}

	}

}
