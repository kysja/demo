<?php 

namespace app\models;

use app\core\DbModel;

class Person extends DbModel
{
    private static array $states = array(
        "AL" => "Alabama", "AK" => "Alaska", "AZ" => "Arizona", "AR" => "Arkansas", "CA" => "California", "CO" => "Colorado", "CT" => "Connecticut", 
        "DE" => "Delaware", "FL" => "Florida", "GA" => "Georgia", "HI" => "Hawaii", "ID" => "Idaho", "IL" => "Illinois", "IN" => "Indiana", 
        "IA" => "Iowa", "KS" => "Kansas", "KY" => "Kentucky", "LA" => "Louisiana", "ME" => "Maine", "MD" => "Maryland", "MA" => "Massachusetts",
        "MI" => "Michigan", "MN" => "Minnesota", "MS" => "Mississippi", "MO" => "Missouri", "MT" => "Montana", "NE" => "Nebraska", "NV" => "Nevada", 
        "NH" => "New Hampshire", "NJ" => "New Jersey", "NM" => "New Mexico", "NY" => "New York", "NC" => "North Carolina", "ND" => "North Dakota", "OH" => "Ohio",
        "OK" => "Oklahoma", "OR" => "Oregon", "PA" => "Pennsylvania", "RI" => "Rhode Island", "SC" => "South Carolina", "SD" => "South Dakota", "TN" => "Tennessee",
        "TX" => "Texas", "UT" => "Utah", "VT" => "Vermont", "VA" => "Virginia", "WA" => "Washington", "WV" => "West Virginia", "WI" => "Wisconsin", "WY" => "Wyoming"
    );


    public static function getList() : array
    {
        $paginate = ['limit' => config('pagination_limit') ?? 100 ];
        $paginate['page'] = (isset($_GET['page']) && intval($_GET['page']) > 0) ? intval($_GET['page']) : 1;
        $paginate['offset'] = ($paginate['page'] - 1) * $paginate['limit'];
        
        $sqlSort = ' ORDER BY '; 
        if (!empty($_GET['sort'])) {
            $sortType = trim(htmlspecialchars($_GET['sort']));
            switch ($sortType) {
                case 'name': 
                    $sqlSort .= ' persons.last_name, persons.first_name, persons.middle_name '; 
                    break;
                case 'number': 
                    $sqlSort .= ' persons.number '; 
                    break;
                case 'company_number':
                    $sqlSort .= ' companies.number ';
                    break;
                default: 
                    $sqlSort .= ' persons.id ';
            }
        } else $sqlSort .= ' persons.id';
        

        $sqlWh = []; // array of WHERE conditions
        $sqlJn = []; // array of JOINs

        $sqlJn['companies'] = 'LEFT JOIN companies ON companies.id = persons.company_id';

        if (isset($_GET['state']) && in_array($_GET['state'], array_keys(self::$states)))
            $sqlWh['state'] = 'companies.state = "' . $_GET['state'] . '"';
        
        if (isset($_GET['search']) && !empty($search = trim(rawurldecode($_GET['search'])))) { // rawurldecode() decodes javascript's encodeURIComponent()
            $searchFields = ['persons.last_name', 'persons.first_name', 'persons.middle_name', 'persons.number', 
                             'CONCAT(persons.last_name, ", ", persons.first_name, " ", persons.middle_name, " ", suffix)',
                             'companies.name', 'companies.city', 'companies.state', 'companies.number', 'companies.zip'];
            $sqlWh['search'] = '(' . implode(' LIKE "%' . $search . '%" OR ', $searchFields) . ' LIKE "%' . $search . '%")'; 
        }

        $sqlWhere = (!empty($sqlWh)>0) ? ' WHERE ' . implode(' AND ', $sqlWh) : '';
        $sqlJoin = implode(' ', $sqlJn);
        $sqlLimit = ' LIMIT ' . $paginate['limit'] . ' OFFSET ' . $paginate['offset'] . ' ';

        $sqlFields = 'persons.*, CONCAT(persons.last_name, ", ", persons.first_name, " ", persons.middle_name, " ", suffix) as full_name, 
                      companies.id as cmp_id, companies.name as cmp_name, companies.city as cmp_city, companies.state as cmp_state, companies.zip as cmp_zip, companies.number as cmp_number';

        $sql = 'SELECT ' . $sqlFields . ' FROM persons ' . $sqlJoin . $sqlWhere . $sqlSort . $sqlLimit;

        $result = self::db()->query($sql);
        $data['rows'] = $result->fetchAll();


        // get total rows for pagination
        $sql = 'SELECT persons.id FROM persons ' . $sqlJoin . $sqlWhere;
        $result = self::db()->query($sql);
        $paginate['total'] = $result->rowCount();
        $paginate['pages'] = ceil($paginate['total'] / $paginate['limit']);

        $data['paginate'] = $paginate;

        return $data;
    }


    public static function getStates() : array
    {
        return self::$states;
    }
    

    public static function isEmptyDb() : bool
    {
        $sql = 'SELECT COUNT(*) FROM persons';
        $countPerson = self::db()->query($sql)->fetchColumn();

        $sql = 'SELECT COUNT(*) FROM companies';
        $countCompany = self::db()->query($sql)->fetchColumn();

        return ($countPerson == 0 && $countCompany == 0);
    }



}