<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateSpendingLimitsView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("
            CREATE OR REPLACE VIEW current_spend_user AS
            SELECT 	us.id as user_id,
                    us.spend_limit_code as code,
                    (SELECT count(*) from requests rq WHERE us.id = rq.user_id) AS requests_count,
                    (SELECT count(*) from contacts co WHERE us.id = co.user_id) AS contacts_count,
                    (SELECT throttle from spend_limits sl WHERE us.spend_limit_code = sl.code) AS throttle,
                    (SELECT requests from spend_limits sl WHERE us.spend_limit_code = sl.code) AS max_requests,
                    (SELECT contacts from spend_limits sl WHERE us.spend_limit_code = sl.code) AS max_contacts,
                    COALESCE((SELECT count(rq.id) from requests rq WHERE rq.user_id = us.id AND DATE_FORMAT(rq.created_at, '%Y-%m-%d') = CURDATE() AND TIME_FORMAT(rq.created_at, '%H:%i') = TIME_FORMAT(CURTIME(), '%H:%i')), 0) AS minute_requests_count,
                    COALESCE((SELECT count(rq.id) from requests rq WHERE rq.user_id = us.id AND DATE_FORMAT(rq.created_at, '%Y-%m-%d') = CURDATE() AND TIME_FORMAT(rq.created_at, '%H') = TIME_FORMAT(CURTIME(), '%H')), 0) AS hour_requests_count,
                    COALESCE((SELECT count(rq.id) from requests rq WHERE rq.user_id = us.id AND DATE_FORMAT(rq.created_at, '%Y-%m-%d') = CURDATE()), 0) AS today_requests_count,
                    COALESCE((SELECT count(rq.id) from requests rq WHERE rq.user_id = us.id AND DATE_FORMAT(rq.created_at, '%Y-%m') = DATE_FORMAT(CURDATE(), '%Y-%m')), 0) AS monthly_requests_count
            FROM users us
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        DB::statement('
            DROP VIEW IF EXISTS current_spend_user
        ');
    }
}
