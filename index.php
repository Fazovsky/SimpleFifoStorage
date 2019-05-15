<?php
 
class Storage {
     
    public $queue = array();
     
    private $_storeAmount;
    public $_pullAmount;
    private $_storePrice;
    public $pullPrice;
    private $_total;
     
    public function store($amount, $price) {
        $this->_storeAmount = $amount;
        $this->_storePrice = $price;
        $this->queue[] = array("amount" => $this->_storeAmount, "price" => $this->_storePrice);
        $total = 0;
        if(!empty($this->queue)) {
            foreach($this->queue as $k => $d) {
                $total += $d['amount'];
            }
            $this->_total = $total;
        } 
    }
     
    public function pull($amount) {
        if (empty($this->_total) || $amount > $this->_total){
            throw new Exception("No bricks in storage");
        }
        $first = $this->queue[0];
        foreach($this->queue as $k => $v) {
            if($first["amount"] >= $amount) {
                $this->queue[$k]["amount"] = $v["amount"] - $amount;
                if($this->queue[$k]["amount"] == 0) {
                    unset($this->queue[$k]);
                }
                $this->_total -= $amount;
                $this->pullPrice = $amount * $v["price"];
                continue;
            } else {
                $_amount = $amount - $v['amount'];
                $needed = $amount - $_amount; 
                echo $_amount. "\n";
                echo $needed. "\n";
//                $this->queue[$k]["amount"] = $amount;
            }
        }
 
        return $this->pullPrice;
         
         
    }
     
}
 
 
$storage = new Storage();
$storage->store(1000, 2.5);
$storage->pull(700);
$storage->store(200, 2.4);
$storage->store(1000, 2.3);
$storage->pull(1000);
 
echo "<pre>";
print_r($storage);
echo "</pre>";
