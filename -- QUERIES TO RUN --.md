-- QUERIES TO RUN --
2022-04-15
ALTER TABLE `agents_upload_share_all` CHANGE `updated_at` `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP;

ALTER TABLE `agents_blog` CHANGE `view` `view` INT(11) NOT NULL DEFAULT '0';

ALTER TABLE `agents_blog` CHANGE `viewer_id` `viewer_id` VARCHAR(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL;
