<?php

namespace Models;

class Utilities {
    
    public function calculateDate($sqlDate)
    {
        date_default_timezone_set('Europe/Paris');
        //Asking php the current date and time
        $current_date = date('Y-m-d H:i:s');
        
        //Using php "DateTime" to tell the difference between two dates
        $datetime1 = new \DateTime($current_date);
        $datetime2 = new \DateTime($sqlDate);
        $interval = $datetime1->diff($datetime2);
        
        //Converting those time and date data into the data we want to display 
        $result = 'Il y a ';
        $continue = true;
        if ($interval->y === 1 && $continue) {
            $result .= $interval->y . ' an, ';
            $continue = false;
        }
        if ($interval->y > 1 && $continue) {
            $result .= $interval->y . ' ans';
            $continue = false;
        }
        if ($interval->m > 1 && $continue) {
            $result .= $interval->m . ' mois';
            $continue = false;
        }
        if ($interval->d === 1 && $continue) {
            $result .= $interval->d . ' jour';
            $continue = false;
        }
        if ($interval->d > 1 && $continue) {
            $result .= $interval->d . ' jours';
            $continue = false;
        }
        if ($interval->h === 1 && $continue) {
            $result .= $interval->h . ' heure, ';
            $continue = false;
        }
        if ($interval->h > 1 && $continue) {
            $result .= $interval->h . ' heures, ';
            $continue = false;
        }
        if ($interval->i > 1 && $continue) {
            $result .= $interval->i . ' minutes';
            $continue = false;
        }
        if ($continue) {
            $result = "À l'instant";
            $continue = false;
        }
        
        //Output the data
        $result = rtrim($result, ', ');
        return $result;
    }
 
}