#
# Table structure for table 'tx_eventsubmission_model_job'
#
CREATE TABLE tx_eventsubmission_model_job
(
    uuid                    varchar(100) DEFAULT '' NOT NULL,
    email                   varchar(255) DEFAULT '' NOT NULL,
    request_date_time       int(11) DEFAULT 0 NOT NULL,
    payload                 text         DEFAULT NULL,
    response_message        text         DEFAULT '' NOT NULL,
    is_api_error            int(1) unsigned DEFAULT 0 NOT NULL,
    job_triggered_date_time int(11) DEFAULT 0 NOT NULL,
    is_done                 int(1) unsigned DEFAULT 0 NOT NULL,
    internal_log_message    varchar(255) DEFAULT '' NOT NULL,
    is_internal_error       int(1) unsigned DEFAULT NULL
);
