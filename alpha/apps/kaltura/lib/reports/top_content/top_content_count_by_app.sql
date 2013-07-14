SELECT 
	COUNT(DISTINCT a.entry_id) count_all
FROM (
	SELECT ev_en.entry_id entry_id
	FROM 
		(SELECT entry_id
		FROM dwh_hourly_events_context_entry_user_app ev, dwh_dim_applications ap
			WHERE
				{OBJ_ID_CLAUSE}
				AND {CAT_ID_CLAUSE}
				AND ap.name = {APPLICATION_NAME}
				AND ap.partner_id = ev.partner_id
				AND ap.application_id = ev.application_id
				AND ev.partner_id =  {PARTNER_ID} # PARTNER_ID
				AND date_id BETWEEN IF({TIME_SHIFT}>0,(DATE({FROM_DATE_ID}) - INTERVAL 1 DAY)*1, {FROM_DATE_ID})  
						AND     IF({TIME_SHIFT}<=0,(DATE({TO_DATE_ID}) + INTERVAL 1 DAY)*1, {TO_DATE_ID})
					AND hour_id >= IF (date_id = IF({TIME_SHIFT}>0,(DATE({FROM_DATE_ID}) - INTERVAL 1 DAY)*1, {FROM_DATE_ID}), IF({TIME_SHIFT}>0, 24 - {TIME_SHIFT}, ABS({TIME_SHIFT})), 0)
					AND hour_id < IF (date_id = IF({TIME_SHIFT}<=0,(DATE({TO_DATE_ID}) + INTERVAL 1 DAY)*1, {TO_DATE_ID}), IF({TIME_SHIFT}>0, 24 - {TIME_SHIFT}, ABS({TIME_SHIFT})), 24)
				AND 
				( count_time_viewed > 0 OR
				  count_plays > 0 OR
				  count_loads > 0 OR
				  sum_time_viewed > 0)) ev_en, dwh_dim_entries e
	WHERE
		ev_en.entry_id=e.entry_id) a