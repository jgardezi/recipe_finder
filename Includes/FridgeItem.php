<?php

class FridgeItem
{

    // the name of the ingredient
    private $itemName;

    // the amount
    private $amount;

    // the unit of measure
    private $unit;

    // Use-by date
    private $expiryDate;

    /**
     * @param mixed $amount
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;
    }

    /**
     * @return mixed
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @param DateTime $expiryDate
     */
    public function setExpiryDate($expiryDate)
    {
        $this->expiryDate = $expiryDate;
    }

    /**
     * @return DateTime
     */
    public function getExpiryDate()
    {
        return $this->expiryDate;
    }

    /**
     * @param mixed $itemName
     */
    public function setItemName($itemName)
    {
        $this->itemName = $itemName;
    }

    /**
     * @return mixed
     */
    public function getItemName()
    {
        return $this->itemName;
    }

    /**
     * @param mixed $unit
     */
    public function setUnit($unit)
    {
        $this->unit = $unit;
    }

    /**
     * @return mixed
     */
    public function getUnit()
    {
        return $this->unit;
    }

    /**
     * Gets all the items in the fridge.
     *
     * @param string $filename
     * @return array|bool
     * @throws Exception
     */
    public function getFridgeItemsData($filename='')
    {
        $fridgeItems = FALSE;
        // use csv file to read the
        $csvArrayData = $this->csvfileToArray($filename);
        if(!$csvArrayData) {
            throw new Exception('No item in the fridge');
        }

        foreach($csvArrayData as $item) {
            $instance = new self();
            $instance->setItemName($item['item']);
            $instance->setAmount($item['amount']);
            $instance->setUnit($item['unit']);
            $date = (isset($item['use-by'])) ? new \DateTime(str_replace('/', '-', $item['use-by'])) : '';
            $instance->setExpiryDate($date);
            $fridgeItems[] = $instance;
        }
        return $fridgeItems;
    }

    /**
     * Reads csv file
     *
     * @param string $filename CSV Data file name.
     * @param string $delimiter CSV file separator
     * @return array|bool
     */
    private function csvfileToArray($filename='', $delimiter=',')
    {
        if(!file_exists($filename) || !is_readable($filename)) {
            return FALSE;
        }

        $header = NULL;
        $data = array();
        if (($handle = fopen($filename, 'r')) !== FALSE) {
            while (($row = fgetcsv($handle, 1000, $delimiter)) !== FALSE) {
                if(!$header) {
                    $header = $row;
                }
                else {
                    $data[] = array_combine($header, $row);
                }
            }
            fclose($handle);
        }
        return $data;
    }

} 