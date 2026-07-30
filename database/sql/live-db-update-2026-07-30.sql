-- ============================================================================
-- Live DB update — 2026-07-30
-- Applies the 8 new migrations (2026_07_29_160728 … 2026_07_30_120000) as raw
-- SQL, for a live database that is currently migrated up to 2026_07_28.
--
--   * BACK UP THE DATABASE BEFORE RUNNING.
--   * Requires MySQL 8.0+ (uses JSON_TYPE / JSON_SET / JSON_ARRAY nesting).
--   * Data UPDATEs are guarded so they are safe to re-run; the ALTER/CREATE
--     statements will simply error with "already exists" if run twice.
--   * Run the whole file top to bottom (phpMyAdmin "SQL" tab or:
--       mysql -u USER -p DATABASE < live-db-update-2026-07-30.sql )
-- ============================================================================


-- ----------------------------------------------------------------------------
-- 1) 2026_07_29_160728_create_doctor_specializations_table
-- ----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `doctor_specializations` (
    `id`          BIGINT UNSIGNED   NOT NULL AUTO_INCREMENT,
    `name`        JSON              NOT NULL,
    `slug`        VARCHAR(255)      NOT NULL,
    `description` JSON              NULL,
    `is_active`   TINYINT(1)        NOT NULL DEFAULT 1,
    `sort_order`  SMALLINT UNSIGNED NOT NULL DEFAULT 0,
    `created_at`  TIMESTAMP         NULL,
    `updated_at`  TIMESTAMP         NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `doctor_specializations_slug_unique` (`slug`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;


-- ----------------------------------------------------------------------------
-- 2) 2026_07_29_160823_add_specialization_id_to_doctors_table
-- ----------------------------------------------------------------------------
ALTER TABLE `doctors`
    ADD COLUMN `doctor_specialization_id` BIGINT UNSIGNED NULL AFTER `specialty`,
    ADD CONSTRAINT `doctors_doctor_specialization_id_foreign`
        FOREIGN KEY (`doctor_specialization_id`)
        REFERENCES `doctor_specializations` (`id`)
        ON DELETE SET NULL;


-- ----------------------------------------------------------------------------
-- 3) 2026_07_29_170919_convert_doctors_name_to_translatable_json
--    Plain "Dr. Name" strings become {"en": "Dr. Name", "bn": ""}.
-- ----------------------------------------------------------------------------
UPDATE `doctors`
SET `name` = JSON_OBJECT('en', `name`, 'bn', '')
WHERE JSON_VALID(`name`) = 0
   OR LEFT(TRIM(`name`), 1) <> '{';

ALTER TABLE `doctors` MODIFY `name` JSON NOT NULL;


-- ----------------------------------------------------------------------------
-- 4) 2026_07_29_173539_convert_doctors_address_phone_to_translatable_json
-- ----------------------------------------------------------------------------
UPDATE `doctors` SET
    `address` = CASE
        WHEN `address` IS NULL OR JSON_VALID(`address`) = 0 OR LEFT(TRIM(`address`), 1) <> '{'
        THEN JSON_OBJECT('en', COALESCE(`address`, ''), 'bn', '')
        ELSE `address` END,
    `phone` = CASE
        WHEN `phone` IS NULL OR JSON_VALID(`phone`) = 0 OR LEFT(TRIM(`phone`), 1) <> '{'
        THEN JSON_OBJECT('en', COALESCE(`phone`, ''), 'bn', '')
        ELSE `phone` END;

ALTER TABLE `doctors` MODIFY `address` JSON NULL;
ALTER TABLE `doctors` MODIFY `phone`   JSON NULL;


-- ----------------------------------------------------------------------------
-- 5) 2026_07_29_173718_reshape_doctors_schedule_items_to_translatable
--    `schedule` is already JSON: [{"day": "Monday", "time": "9-5"}, ...].
--    Each day/time string becomes {"en": "...", "bn": ""}. One statement per
--    array index keeps the original item order and is idempotent (already-
--    converted objects are left untouched).
--
--    Covers items 0-9. Check the real maximum first — if it is above 10,
--    copy the block for the extra indexes:
--        SELECT MAX(JSON_LENGTH(`schedule`)) FROM `doctors`;
-- ----------------------------------------------------------------------------
UPDATE `doctors` SET `schedule` = JSON_SET(`schedule`,
    '$[0].day',  CASE WHEN JSON_TYPE(JSON_EXTRACT(`schedule`, '$[0].day')) = 'STRING'
                      THEN JSON_OBJECT('en', JSON_UNQUOTE(JSON_EXTRACT(`schedule`, '$[0].day')), 'bn', '')
                      ELSE COALESCE(JSON_EXTRACT(`schedule`, '$[0].day'), JSON_OBJECT('en', '', 'bn', '')) END,
    '$[0].time', CASE WHEN JSON_TYPE(JSON_EXTRACT(`schedule`, '$[0].time')) = 'STRING'
                      THEN JSON_OBJECT('en', JSON_UNQUOTE(JSON_EXTRACT(`schedule`, '$[0].time')), 'bn', '')
                      ELSE COALESCE(JSON_EXTRACT(`schedule`, '$[0].time'), JSON_OBJECT('en', '', 'bn', '')) END)
WHERE `schedule` IS NOT NULL AND JSON_LENGTH(`schedule`) > 0;

UPDATE `doctors` SET `schedule` = JSON_SET(`schedule`,
    '$[1].day',  CASE WHEN JSON_TYPE(JSON_EXTRACT(`schedule`, '$[1].day')) = 'STRING'
                      THEN JSON_OBJECT('en', JSON_UNQUOTE(JSON_EXTRACT(`schedule`, '$[1].day')), 'bn', '')
                      ELSE COALESCE(JSON_EXTRACT(`schedule`, '$[1].day'), JSON_OBJECT('en', '', 'bn', '')) END,
    '$[1].time', CASE WHEN JSON_TYPE(JSON_EXTRACT(`schedule`, '$[1].time')) = 'STRING'
                      THEN JSON_OBJECT('en', JSON_UNQUOTE(JSON_EXTRACT(`schedule`, '$[1].time')), 'bn', '')
                      ELSE COALESCE(JSON_EXTRACT(`schedule`, '$[1].time'), JSON_OBJECT('en', '', 'bn', '')) END)
WHERE `schedule` IS NOT NULL AND JSON_LENGTH(`schedule`) > 1;

UPDATE `doctors` SET `schedule` = JSON_SET(`schedule`,
    '$[2].day',  CASE WHEN JSON_TYPE(JSON_EXTRACT(`schedule`, '$[2].day')) = 'STRING'
                      THEN JSON_OBJECT('en', JSON_UNQUOTE(JSON_EXTRACT(`schedule`, '$[2].day')), 'bn', '')
                      ELSE COALESCE(JSON_EXTRACT(`schedule`, '$[2].day'), JSON_OBJECT('en', '', 'bn', '')) END,
    '$[2].time', CASE WHEN JSON_TYPE(JSON_EXTRACT(`schedule`, '$[2].time')) = 'STRING'
                      THEN JSON_OBJECT('en', JSON_UNQUOTE(JSON_EXTRACT(`schedule`, '$[2].time')), 'bn', '')
                      ELSE COALESCE(JSON_EXTRACT(`schedule`, '$[2].time'), JSON_OBJECT('en', '', 'bn', '')) END)
WHERE `schedule` IS NOT NULL AND JSON_LENGTH(`schedule`) > 2;

UPDATE `doctors` SET `schedule` = JSON_SET(`schedule`,
    '$[3].day',  CASE WHEN JSON_TYPE(JSON_EXTRACT(`schedule`, '$[3].day')) = 'STRING'
                      THEN JSON_OBJECT('en', JSON_UNQUOTE(JSON_EXTRACT(`schedule`, '$[3].day')), 'bn', '')
                      ELSE COALESCE(JSON_EXTRACT(`schedule`, '$[3].day'), JSON_OBJECT('en', '', 'bn', '')) END,
    '$[3].time', CASE WHEN JSON_TYPE(JSON_EXTRACT(`schedule`, '$[3].time')) = 'STRING'
                      THEN JSON_OBJECT('en', JSON_UNQUOTE(JSON_EXTRACT(`schedule`, '$[3].time')), 'bn', '')
                      ELSE COALESCE(JSON_EXTRACT(`schedule`, '$[3].time'), JSON_OBJECT('en', '', 'bn', '')) END)
WHERE `schedule` IS NOT NULL AND JSON_LENGTH(`schedule`) > 3;

UPDATE `doctors` SET `schedule` = JSON_SET(`schedule`,
    '$[4].day',  CASE WHEN JSON_TYPE(JSON_EXTRACT(`schedule`, '$[4].day')) = 'STRING'
                      THEN JSON_OBJECT('en', JSON_UNQUOTE(JSON_EXTRACT(`schedule`, '$[4].day')), 'bn', '')
                      ELSE COALESCE(JSON_EXTRACT(`schedule`, '$[4].day'), JSON_OBJECT('en', '', 'bn', '')) END,
    '$[4].time', CASE WHEN JSON_TYPE(JSON_EXTRACT(`schedule`, '$[4].time')) = 'STRING'
                      THEN JSON_OBJECT('en', JSON_UNQUOTE(JSON_EXTRACT(`schedule`, '$[4].time')), 'bn', '')
                      ELSE COALESCE(JSON_EXTRACT(`schedule`, '$[4].time'), JSON_OBJECT('en', '', 'bn', '')) END)
WHERE `schedule` IS NOT NULL AND JSON_LENGTH(`schedule`) > 4;

UPDATE `doctors` SET `schedule` = JSON_SET(`schedule`,
    '$[5].day',  CASE WHEN JSON_TYPE(JSON_EXTRACT(`schedule`, '$[5].day')) = 'STRING'
                      THEN JSON_OBJECT('en', JSON_UNQUOTE(JSON_EXTRACT(`schedule`, '$[5].day')), 'bn', '')
                      ELSE COALESCE(JSON_EXTRACT(`schedule`, '$[5].day'), JSON_OBJECT('en', '', 'bn', '')) END,
    '$[5].time', CASE WHEN JSON_TYPE(JSON_EXTRACT(`schedule`, '$[5].time')) = 'STRING'
                      THEN JSON_OBJECT('en', JSON_UNQUOTE(JSON_EXTRACT(`schedule`, '$[5].time')), 'bn', '')
                      ELSE COALESCE(JSON_EXTRACT(`schedule`, '$[5].time'), JSON_OBJECT('en', '', 'bn', '')) END)
WHERE `schedule` IS NOT NULL AND JSON_LENGTH(`schedule`) > 5;

UPDATE `doctors` SET `schedule` = JSON_SET(`schedule`,
    '$[6].day',  CASE WHEN JSON_TYPE(JSON_EXTRACT(`schedule`, '$[6].day')) = 'STRING'
                      THEN JSON_OBJECT('en', JSON_UNQUOTE(JSON_EXTRACT(`schedule`, '$[6].day')), 'bn', '')
                      ELSE COALESCE(JSON_EXTRACT(`schedule`, '$[6].day'), JSON_OBJECT('en', '', 'bn', '')) END,
    '$[6].time', CASE WHEN JSON_TYPE(JSON_EXTRACT(`schedule`, '$[6].time')) = 'STRING'
                      THEN JSON_OBJECT('en', JSON_UNQUOTE(JSON_EXTRACT(`schedule`, '$[6].time')), 'bn', '')
                      ELSE COALESCE(JSON_EXTRACT(`schedule`, '$[6].time'), JSON_OBJECT('en', '', 'bn', '')) END)
WHERE `schedule` IS NOT NULL AND JSON_LENGTH(`schedule`) > 6;

UPDATE `doctors` SET `schedule` = JSON_SET(`schedule`,
    '$[7].day',  CASE WHEN JSON_TYPE(JSON_EXTRACT(`schedule`, '$[7].day')) = 'STRING'
                      THEN JSON_OBJECT('en', JSON_UNQUOTE(JSON_EXTRACT(`schedule`, '$[7].day')), 'bn', '')
                      ELSE COALESCE(JSON_EXTRACT(`schedule`, '$[7].day'), JSON_OBJECT('en', '', 'bn', '')) END,
    '$[7].time', CASE WHEN JSON_TYPE(JSON_EXTRACT(`schedule`, '$[7].time')) = 'STRING'
                      THEN JSON_OBJECT('en', JSON_UNQUOTE(JSON_EXTRACT(`schedule`, '$[7].time')), 'bn', '')
                      ELSE COALESCE(JSON_EXTRACT(`schedule`, '$[7].time'), JSON_OBJECT('en', '', 'bn', '')) END)
WHERE `schedule` IS NOT NULL AND JSON_LENGTH(`schedule`) > 7;

UPDATE `doctors` SET `schedule` = JSON_SET(`schedule`,
    '$[8].day',  CASE WHEN JSON_TYPE(JSON_EXTRACT(`schedule`, '$[8].day')) = 'STRING'
                      THEN JSON_OBJECT('en', JSON_UNQUOTE(JSON_EXTRACT(`schedule`, '$[8].day')), 'bn', '')
                      ELSE COALESCE(JSON_EXTRACT(`schedule`, '$[8].day'), JSON_OBJECT('en', '', 'bn', '')) END,
    '$[8].time', CASE WHEN JSON_TYPE(JSON_EXTRACT(`schedule`, '$[8].time')) = 'STRING'
                      THEN JSON_OBJECT('en', JSON_UNQUOTE(JSON_EXTRACT(`schedule`, '$[8].time')), 'bn', '')
                      ELSE COALESCE(JSON_EXTRACT(`schedule`, '$[8].time'), JSON_OBJECT('en', '', 'bn', '')) END)
WHERE `schedule` IS NOT NULL AND JSON_LENGTH(`schedule`) > 8;

UPDATE `doctors` SET `schedule` = JSON_SET(`schedule`,
    '$[9].day',  CASE WHEN JSON_TYPE(JSON_EXTRACT(`schedule`, '$[9].day')) = 'STRING'
                      THEN JSON_OBJECT('en', JSON_UNQUOTE(JSON_EXTRACT(`schedule`, '$[9].day')), 'bn', '')
                      ELSE COALESCE(JSON_EXTRACT(`schedule`, '$[9].day'), JSON_OBJECT('en', '', 'bn', '')) END,
    '$[9].time', CASE WHEN JSON_TYPE(JSON_EXTRACT(`schedule`, '$[9].time')) = 'STRING'
                      THEN JSON_OBJECT('en', JSON_UNQUOTE(JSON_EXTRACT(`schedule`, '$[9].time')), 'bn', '')
                      ELSE COALESCE(JSON_EXTRACT(`schedule`, '$[9].time'), JSON_OBJECT('en', '', 'bn', '')) END)
WHERE `schedule` IS NOT NULL AND JSON_LENGTH(`schedule`) > 9;


-- ----------------------------------------------------------------------------
-- 6) 2026_07_29_173825_convert_doctor_chambers_to_translatable_json
-- ----------------------------------------------------------------------------
UPDATE `doctor_chambers` SET
    `name` = CASE
        WHEN JSON_VALID(`name`) = 0 OR LEFT(TRIM(`name`), 1) <> '{'
        THEN JSON_OBJECT('en', COALESCE(`name`, ''), 'bn', '')
        ELSE `name` END,
    `hospital_branch` = CASE
        WHEN `hospital_branch` IS NULL OR JSON_VALID(`hospital_branch`) = 0 OR LEFT(TRIM(`hospital_branch`), 1) <> '{'
        THEN JSON_OBJECT('en', COALESCE(`hospital_branch`, ''), 'bn', '')
        ELSE `hospital_branch` END,
    `floor` = CASE
        WHEN `floor` IS NULL OR JSON_VALID(`floor`) = 0 OR LEFT(TRIM(`floor`), 1) <> '{'
        THEN JSON_OBJECT('en', COALESCE(`floor`, ''), 'bn', '')
        ELSE `floor` END,
    `room_no` = CASE
        WHEN `room_no` IS NULL OR JSON_VALID(`room_no`) = 0 OR LEFT(TRIM(`room_no`), 1) <> '{'
        THEN JSON_OBJECT('en', COALESCE(`room_no`, ''), 'bn', '')
        ELSE `room_no` END,
    `address` = CASE
        WHEN `address` IS NULL OR JSON_VALID(`address`) = 0 OR LEFT(TRIM(`address`), 1) <> '{'
        THEN JSON_OBJECT('en', COALESCE(`address`, ''), 'bn', '')
        ELSE `address` END,
    `contact_number` = CASE
        WHEN `contact_number` IS NULL OR JSON_VALID(`contact_number`) = 0 OR LEFT(TRIM(`contact_number`), 1) <> '{'
        THEN JSON_OBJECT('en', COALESCE(`contact_number`, ''), 'bn', '')
        ELSE `contact_number` END;

ALTER TABLE `doctor_chambers` MODIFY `name`            JSON NOT NULL;
ALTER TABLE `doctor_chambers` MODIFY `hospital_branch` JSON NULL;
ALTER TABLE `doctor_chambers` MODIFY `floor`           JSON NULL;
ALTER TABLE `doctor_chambers` MODIFY `room_no`         JSON NULL;
ALTER TABLE `doctor_chambers` MODIFY `address`         JSON NULL;
ALTER TABLE `doctor_chambers` MODIFY `contact_number`  JSON NULL;


-- ----------------------------------------------------------------------------
-- 7) 2026_07_29_190000_convert_doctor_info_table_fields_to_lists
--    specialty / degrees / experience / awards were single {"en","bn"} maps;
--    they become lists: [{"en","bn"}, ...]. A map that is blank in every
--    locale becomes []; a leftover bare string becomes [{"en": "..."}];
--    values that are already lists are left untouched.
-- ----------------------------------------------------------------------------
UPDATE `doctors` SET
    `specialty` = CASE
        WHEN `specialty` IS NULL OR JSON_TYPE(`specialty`) = 'ARRAY' THEN `specialty`
        WHEN JSON_TYPE(`specialty`) = 'OBJECT' THEN CASE
            WHEN TRIM(COALESCE(JSON_UNQUOTE(JSON_EXTRACT(`specialty`, '$.en')), '')) = ''
             AND TRIM(COALESCE(JSON_UNQUOTE(JSON_EXTRACT(`specialty`, '$.bn')), '')) = ''
            THEN JSON_ARRAY()
            ELSE JSON_ARRAY(`specialty`) END
        ELSE JSON_ARRAY(JSON_OBJECT('en', COALESCE(JSON_UNQUOTE(`specialty`), ''))) END,
    `degrees` = CASE
        WHEN `degrees` IS NULL OR JSON_TYPE(`degrees`) = 'ARRAY' THEN `degrees`
        WHEN JSON_TYPE(`degrees`) = 'OBJECT' THEN CASE
            WHEN TRIM(COALESCE(JSON_UNQUOTE(JSON_EXTRACT(`degrees`, '$.en')), '')) = ''
             AND TRIM(COALESCE(JSON_UNQUOTE(JSON_EXTRACT(`degrees`, '$.bn')), '')) = ''
            THEN JSON_ARRAY()
            ELSE JSON_ARRAY(`degrees`) END
        ELSE JSON_ARRAY(JSON_OBJECT('en', COALESCE(JSON_UNQUOTE(`degrees`), ''))) END,
    `experience` = CASE
        WHEN `experience` IS NULL OR JSON_TYPE(`experience`) = 'ARRAY' THEN `experience`
        WHEN JSON_TYPE(`experience`) = 'OBJECT' THEN CASE
            WHEN TRIM(COALESCE(JSON_UNQUOTE(JSON_EXTRACT(`experience`, '$.en')), '')) = ''
             AND TRIM(COALESCE(JSON_UNQUOTE(JSON_EXTRACT(`experience`, '$.bn')), '')) = ''
            THEN JSON_ARRAY()
            ELSE JSON_ARRAY(`experience`) END
        ELSE JSON_ARRAY(JSON_OBJECT('en', COALESCE(JSON_UNQUOTE(`experience`), ''))) END,
    `awards` = CASE
        WHEN `awards` IS NULL OR JSON_TYPE(`awards`) = 'ARRAY' THEN `awards`
        WHEN JSON_TYPE(`awards`) = 'OBJECT' THEN CASE
            WHEN TRIM(COALESCE(JSON_UNQUOTE(JSON_EXTRACT(`awards`, '$.en')), '')) = ''
             AND TRIM(COALESCE(JSON_UNQUOTE(JSON_EXTRACT(`awards`, '$.bn')), '')) = ''
            THEN JSON_ARRAY()
            ELSE JSON_ARRAY(`awards`) END
        ELSE JSON_ARRAY(JSON_OBJECT('en', COALESCE(JSON_UNQUOTE(`awards`), ''))) END;


-- ----------------------------------------------------------------------------
-- 8) 2026_07_30_120000_add_seal_image_to_awards_table
-- ----------------------------------------------------------------------------
ALTER TABLE `awards`
    ADD COLUMN `seal_image` VARCHAR(255) NULL AFTER `link_url`;


-- ----------------------------------------------------------------------------
-- 9) Register the migrations so `php artisan migrate` will not re-run them.
--    (Only inserts names that are not already present.)
-- ----------------------------------------------------------------------------
SET @next_batch = (SELECT COALESCE(MAX(`batch`), 0) + 1 FROM `migrations`);

INSERT INTO `migrations` (`migration`, `batch`)
SELECT t.`migration`, @next_batch
FROM (
    SELECT '2026_07_29_160728_create_doctor_specializations_table' AS `migration`
    UNION ALL SELECT '2026_07_29_160823_add_specialization_id_to_doctors_table'
    UNION ALL SELECT '2026_07_29_170919_convert_doctors_name_to_translatable_json'
    UNION ALL SELECT '2026_07_29_173539_convert_doctors_address_phone_to_translatable_json'
    UNION ALL SELECT '2026_07_29_173718_reshape_doctors_schedule_items_to_translatable'
    UNION ALL SELECT '2026_07_29_173825_convert_doctor_chambers_to_translatable_json'
    UNION ALL SELECT '2026_07_29_190000_convert_doctor_info_table_fields_to_lists'
    UNION ALL SELECT '2026_07_30_120000_add_seal_image_to_awards_table'
) t
WHERE NOT EXISTS (
    SELECT 1 FROM `migrations` m WHERE m.`migration` = t.`migration`
);


-- ----------------------------------------------------------------------------
-- Verification (read-only — run after the script to sanity-check)
-- ----------------------------------------------------------------------------
-- SHOW CREATE TABLE doctor_specializations;
-- SHOW COLUMNS FROM doctors   LIKE 'doctor_specialization_id';
-- SHOW COLUMNS FROM awards    LIKE 'seal_image';
-- SELECT id, name, address, phone, specialty, schedule FROM doctors LIMIT 5;
-- SELECT id, name, hospital_branch, address FROM doctor_chambers LIMIT 5;
-- SELECT migration, batch FROM migrations ORDER BY id DESC LIMIT 10;
