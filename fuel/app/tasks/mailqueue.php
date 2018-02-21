<?php

namespace Fuel\Tasks;

use Fuel\Core\Log;

/**
 * author thuanth6589
 * Class Mailqueue
 * @package Fuel\Tasks
 */
class Mailqueue
{
    /**
     * send mail
     * @param $data
     * @return bool
     */
    private function send_mail($data)
    {
        $mail_sent = [];
        foreach ($data as $key => $value) {
            if (trim($value['mail_to'], ',')) {
                $email = \Email::forge();
                $from = explode(',', $value['mail_from']);
                $email->from($from[0], $from[1]);
                $mail_to = array_filter(explode(',', $value['mail_to']));
                $email->to($mail_to);
                $email->subject($value['subject']);
                $email->body($value['body']);
                try {
                    $email->send();
                    $mail_sent[] = $value['queue_id'];
                    \Config::set('log_threshold', \Fuel::L_INFO);
                    Log::info('Mail sent success: ' . json_encode(['mail_to' => $mail_to, 'subject' => $value['subject']]));
                } catch (\EmailValidationFailedException $e) {
                    Log::error('Mail validation: ' . json_encode(['mail_to' => $mail_to, 'subject' => $value['subject']]));
                } catch (\EmailSendingFailedException $e) {
                    Log::error('Mail send failed: ' . json_encode(['mail_to' => $mail_to, 'subject' => $value['subject']]));
                }
            }
        }
        return $mail_sent;
    }

    /**
     * run task
     */
    public function run()
    {
        $mail_queue = new \Model_Mailqueue();
        $data = $mail_queue->get_data(['now' => date('Y-m-d H:i:s', time())]);
        $mail_sent = $this->send_mail($data);
        $delete = $mail_queue->delete_by_id($mail_sent);
        if(!isset($delete)) {
            Log::error('Delete mail queue failed: '. json_encode($mail_sent));
        }
    }

}
