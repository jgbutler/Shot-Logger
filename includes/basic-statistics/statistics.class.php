<?php

Class Statistics {
    private $round=2;
    public $scores, $frequency, $pn, $sn, $fx, $XminA, $XminAsqr, $rf, $rfp, $cf;
    public $mean, $median, $mode;
    public $range, $iqr, $pv, $sv, $psd, $ssd, $q, $max, $min;

    function __Construct($scores=array(1),$round=2) {
        if(is_array($scores) && is_int($round)) {
            $this->round = $round;
            $this->scores = self::cleanArray($scores);
            $this->frequency = self::Calculate_F();
            $this->pn = count($this->scores);
            $this->sn = count($this->scores) - 1;
        } else {
            trigger_error('No valid array supplied.', E_USER_ERROR);
        }
    }

    /*
     * Clean an array of non-numeric values
     *
     * @param array $x Set of numbers
     * @access private
     * @return array Scores
     */
    private function cleanArray($x) {
        if(is_array($x)) {
            $cleanScores = array();
            foreach($x as $dirty => $val){
                if($val == 0) {
                    unset($cleanScores[$dirty]);
                }
                else {
                    $cleanScores[] = (string)$val;
                }
            }
            sort($cleanScores);
        } else {
            trigger_error('This is not a valid array.', E_USER_ERROR);
        }
        return $cleanScores;
    }

    /*
     * Return Scores
     *
     * @return array Scores
     */
    public function Get_Scores() {
        return $this->scores;
    }

    /**
     * Calculate Frequency
     *
     * @return array Frequency
     */
    public function Calculate_F() {
        return array_count_values($this->scores);
    }

    /**
     * Return Frequency
     *
     * @return array Frequency
     */
    public function Get_Frequency() {
        return $this->frequency;
    }

    /**
     * Return Population Size
     *
     * @return int Pn
     */
    public function Get_PN() {
        return $this->pn;
    }

    /**
     * Return Sample Size
     *
     * @return int Sn
     */
    public function Get_SN() {
        return $this->sn;
    }

    /**
     * Return Quartiles 1, 2 and 3
     *
     * @return array Q
     */
    public function Get_Q() {
        return $this->q;
    }

    /*
     * Calculate Quartiles 1, 2 and 3
     *
     * @return array Q
     */
    public function Find_Q() {
        $this->q = array();
        $this->q[1] = self::Percentile($this->scores, 25);
        $this->q[2] = self::Percentile($this->scores, 50);
        $this->q[3] = self::Percentile($this->scores, 75);
        return $this->q;
    }

    /*
     * Calculate FX (F * X) (Frequency * Scores)
     *
     * @return array Fx
     */
    public function Calculate_FX() {
        $frequency = $this->frequency;

        foreach($this->scores as $key=>$value){
            $newValue = $value * $frequency[$value];
            $this->fx[$key] = round($newValue,$this->round);
        }
        return $this->fx;
    }

    /*
     * Return FX
     *
     * @return array Fx
     */
    public function Get_FX() {
        return $this->fx;
    }

    /*
     * Calculate the Mean
     *
     * @return mixed Mean
     */
    public function Find_Mean() {
        $total = 0;
        foreach($this->scores as $score) {
            $total += $score;
        }
        return $this->mean = round(($total / $this->pn),$this->round);
    }

    /*
     * Return the Mean
     *
     * @return mixed Mean
     */
    public function Get_Mean() {
        return $this->mean;
    }

    /*
     * Calculate the Median
     *
     * @return mixed Median
     */
    public function Find_Median() {
        if(!isset($this->q)) {
            $this->q = self::Find_Q();
        }
        return $this->median = $this->q[2];
    }

    /*
     * Return the Median
     *
     * @return mixed Median
     */
    public function Get_Median() {
        return $this->median;
    }

    /*
     * Calculate the Mode
     *
     * @return mixed Mode
     */
    public function Find_Mode() {
        $counted = array_count_values($this->scores);
        arsort($counted);
        return $this->mode = key($counted);
    }

    /*
     * Return the Mode
     *
     * @return mixed Mode
     */
    public function Get_Mode() {
        return $this->mode;
    }

    /*
     * Calculate the Range
     *
     * @return mixed Range
     */
    public function Find_Range() {
        if(!isset($this->max)) {
            $this->max = self::Find_Max();
        }
        if(!isset($this->min)) {
            $this->min = self::Find_Min();
        }
        return $this->range = $this->max - $this->min;
    }

    /*
     * Return the Range
     *
     * @return mixed Range
     */
    public function Get_Range() {
        return $this->range;
    }

    /*
     * Calculate the Highest Value
     *
     * @return mixed Max
     */
    public function Find_Max() {
        return $this->max = max($this->scores);
    }

    /*
     * Calculate the Lowest Value
     *
     * @return mixed Min
     */
    public function Find_Min() {
        return $this->min = min($this->scores);
    }

    /*
     * Return the Highest Value
     *
     * @return mixed Max
     */
    public function Get_Max() {
        return $this->max;
    }

    /*
     * Return the Lowest Value
     *
     * @return mixed Min
     */
    public function Get_Min() {
        return $this->min;
    }

    /*
     * Calculate (X - Mean) OR (X - Mean) squared
     *
     * @param bool $sqr
     * @return array
     */
    public function Calculate_XminAvg($sqr=false) {
        if(!isset($this->mean)) {
            $this->mean = self::Find_Mean();
        }
        $mean = $this->mean;
        $XminA = array();
        foreach($this->scores as $key => $val) {
            ($sqr == true) ? $XminA[$val] = round(pow(($val - $mean),2),$this->round) : $XminA[$val] = round(($val - $mean),$this->round);
        }
        if($sqr == true) {
            return $this->XminAsqr = $XminA;
        }
        else {
            return $this->XminA = $XminA;
        }
    }

    /*
     * Return (X - Mean)
     *
     * @return array XminA
     */
    public function Get_XminAvg() {
        return $this->XminA;
    }

    /*
     * Return (X - Mean) squared
     *
     * @return array XminAsqr
     */
    public function Get_XminAvgsqr() {
        return $this->XminAsqr;
    }

    /*
     * Calculate the Interquartle Range
     *
     * @return mixed Iqr
     */
    public function Find_IQR() {
        if(!isset($this->q)) {
            $this->q = self::Find_Q();
        }
        return $this->iqr = $this->q[3] - $this->q[1];
    }

    /*
     * Return the Interquartile Range
     *
     * @return mixed Iqr
     */
    public function Get_IQR() {
        return $this->iqr;
    }

    /*
     * Calculate the score at a certain percentile within an array
     *
     * @param array $x Set of numbers, $percentile
     * @access private
     * @return mixed Percentile
     */
    private function Percentile($x,$percentile){
		if(0 < $percentile && $percentile < 1) {
			$p = $percentile;
		} elseif(1 < $percentile && $percentile <= 100) {
			$p = $percentile * .01;
		} else {
			return "";
		}
		$count = count($x);
		$allindex = ($count-1)*$p;
		$intvalindex = intval($allindex);
		$floatval = $allindex - $intvalindex;
		sort($x);
		if(!is_float($floatval)){
			$result = $x[$intvalindex];
		} else {
			if($count > $intvalindex+1) {
				$result = $floatval*($x[$intvalindex+1] - $x[$intvalindex]) + $x[$intvalindex];
                        }
			else {
				$result = $x[$intvalindex];
                        }
		}
		return $result;
    }

    /*
     * Calculate the Population or Sample Variance
     *
     * @param string $ps 'p' for population or 's' for sample
     * @return mixed
     */
    public function Find_V($ps='p') {
        if(!isset($this->XminA)) {
            $this->XminA = self::Calculate_XminAvg(true);
        }
        ($ps == 'p') ? $n = $this->pn : $n = $this->sn;
        $sumXminAsqr = array_sum($this->XminA);
        return round(($sumXminAsqr) / $n,$this->round);
    }

    /*
     * Return the Population Variance
     *
     * @return mixed Pv
     */
    public function Get_PV() {
        return $this->pv;
    }

    /*
     * Return the Sample Variance
     *
     * @return mixed Sv
     */
    public function Get_SV() {
        return $this->sv;
    }

    /*
     * Calculate the Sample Standard Deviation or Population Standard Deviation
     *
     * @param string $ps 'p' for population or 's' for sample
     * @return mixed Sd
     */
     public function Find_SD($ps='p') {
         switch($ps) {
            case 'p':
                if(!isset($this->pv)) {
                    $this->pv = self::Find_V('p');
                }
                $v = $this->pv;
            break;
            case 's':
                if(!isset($this->sv)) {
                    $this->sv = self::Find_V('s');
                }
                $v = $this->sv;
            break;
         }
         return round(sqrt($v),$this->round);
     }

    /*
     * Return Population Standard Deviation
     *
     * @return mixed Psd
     */
    public function Get_PSD() {
        return $this->psd;
    }

    /*
     * Return Sample Standard Deviation
     *
     * @return mixed Ssd
     */
    public function Get_SSD() {
        return $this->ssd;
    }

    /*
     * Calculate Relative Frequency
     *
     * @return array Rf
     */
    public function Calculate_RF() {
        $f = $this->frequency;
        $fsum = array_sum($f);
        $rf = array();
        foreach($f as $f) {
            $rf[] = round(($f / $fsum),$this->round);
        }
        return $this->rf = $rf;
    }

    /*
     * Return Relative Frequency
     *
     * @return array Rf
     */
    public function Get_RF() {
        return $this->rf;
    }

    /*
     * Calculate Relative Frequency Percentages
     *
     * @return array Rfp
     */
    public function Calculate_RFP() {
        $rfp = array();
        foreach($this->rf as $f) {
            $rfp[] = round(($f * 100),$this->round);
        }
        return $this->rfp = $rfp;
    }

    /*
     * Return Relative Frequency Percentages
     *
     * @return array Rfp
     */
    public function Get_RFP() {
        return $this->rfp;
    }

    /*
     * Calculate Cumulative Frequency
     *
     * @return array Cf
     */
    public function Calculate_CF() {
        $cf = array();
        $total = 0;
        foreach($this->frequency as $f) {
            $total += $f;
            $cf[] = $total;
        }
        return $this->cf = $cf;
    }

    /*
     * Return Cumulative Frequency
     *
     * @return array Cf
     */
    public function Get_CF() {
        return $this->cf;
    }

}

?>