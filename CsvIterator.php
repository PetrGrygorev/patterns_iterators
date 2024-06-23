<?php

class CsvIterator implements Iterator
{
    const ROW_SIZE = 4096;
 
    // Указатель на CSV-файл ( @var resource )
    public $filePointer = null;
 
    // Текущий элемент, который возвращается на каждой итерации ( @var array )
    public $currentElement = null;

    // Счётчик строк ( @var int )
    public $rowCounter = null;
 
    // $delimiter  - разделитель для CSV-файла ( @var string )
    public $delimiter;

    /** Конструктор пытается открыть CSV-файл. Он выдаёт исключение при ошибке.
     * @param string $file CSV-файл.
     * @param string $delimiter Разделитель.
     * @throws \Exception   */
    public function __construct($file, $delimiter = '<')
    {
        try {
            $this->filePointer = fopen($file, 'rb');
            $this->delimiter = $delimiter;

        } catch (\Exception $e) {
            throw new \Exception('Файл "' . $file . '" не открывается');
        }
    }
 
    // Этот метод сбрасывает указатель файла (не используется в этом проекте)
    public function rewind(): void    {
        $this->rowCounter = 0;
        rewind($this->filePointer);
    }
 
    /** Этот метод возвращает текущую CSV-строку в виде двумерного массива.
     * @return array Текущая CSV-строка в виде двумерного массива.  */
    public function current(): array    {
        $this->currentElement = fgetcsv($this->filePointer, self::ROW_SIZE, $this->delimiter);
        $this->rowCounter++;
        return $this->currentElement;
    }
 
    /** Этот метод возвращает номер текущей строки (не используется в этом проекте)
     * @return int Номер текущей строки.  */   
    public function key(): int    {
        return $this->rowCounter;
    }
 
    // (не используется в этом проекте)
    public function next(): void  { }

    /** Этот метод проверяет, является ли следующая строка допустимой.
     * @return bool Если следующая строка является допустимой.*/
    public function valid(): bool  {
        
        if (is_resource($this->filePointer))    {                  // если filePointer - ресурс (открытый файл) 
            if (feof($this->filePointer))         {                // если достигнут конец файла
                fclose($this->filePointer);                         // закрываем файл
            return false;                                          
            }
        }
        return true;
    }
}
