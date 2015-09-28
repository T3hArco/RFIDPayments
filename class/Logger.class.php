<?php
/**
 * Created by IntelliJ IDEA.
 * User: arnaudcoel
 * Date: 28/09/15
 * Time: 14:06
 */

namespace helpers;


class Logger
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function log($type, $data)
    {
        if (isset($_SESSION['id']))
            $user = $_SESSION['id'];

        else
            $user = 0;

        $ip = $_SERVER['REMOTE_ADDR'];
        $page = $_SERVER['REQUEST_URI'];

        $log = $this->db->prepare("INSERT INTO log(user, datetime, type, page, ip, data) VALUES(?, NOW(), ?, ?, ?, ?)");
        $log->execute(array($user, $type, $page, $ip, $data));
    }

    public function buildLogTable()
    {
        $entries = $this->db->query("SELECT * FROM log l JOIN users u ON(l.user = u.id) ORDER BY l.id DESC");
        $output = '<table class="table table-hover"><thead><th>#</th><th>User</th><th>Timestamp</th><th>Type</th><th>Page</th><th>IP</th><th>Data</th></thead>';

        foreach ($entries as $entry) {
            $class = "";
            switch($entry['type']) {
                case 'ERROR':
                    $class = " class='warning'";
                    break;

                case 'INTRUSION':
                case 'FAILEDLOG':
                    $class = " class='danger'";
                    break;
            }

            $output .= '<tr' . $class . '><th scope="row">' . $entry[0] . '</th><td>' . $entry['username'] . ' (' . $entry['user'] . ')</td><td>' . $entry['datetime'] . '</td><td>' . $entry['type'] . '</td><td>' . $entry['page'] . '</td><td>' . $entry['ip'] . '</td><td>' . $entry['data'] . '</td></tr>';
        }

        $output .= '</table>';
        return $output;
    }
}