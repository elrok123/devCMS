CREATE EVENT available_users_updater
    ON SCHEDULE
    	EVERY 1 MINUTE
    COMMENT 'Sets online users to offline to wait for poll.'
    DO
      UPDATE users SET online=0 WHERE online=1;