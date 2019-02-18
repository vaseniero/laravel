<?php

namespace App;

use Goutte;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class Passer extends Model
{
    /**
     * The table associated with the model
     * 
     * @var string
     */
    protected $table = 'passers';

    /**
     * The attributes that are mass assignable.
     * 
     * @var array
     */
    protected $fillable = ['id'];

    private $row;
    private $col;
    private $obj;

    public function __construct(array $attributes = [])
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        DB::table('passers')->truncate();

        $this->row = 0;
        $this->col = 0;
        $this->obj = array();
    }

    public function scrape()
    {
        $crawler = Goutte::request('GET', env('PSHS_NCE_PASSERS_URL'));

        $crawler->filter('.container_list div .border_list')->each(function ($node) {
            $item = $node->text();

            $this->dump_scrape_and_save($item,$this->col,$this->obj);

            // long process of scrape and save
            // comment out
            //$this->dump_scrape($item,$this->row,$this->col,$this->obj);
        });

        // long process of scrape and save
        // comment out
        //$this->save_dump_scrape();
    }

    private function dump_scrape_and_save($item,$col,$obj)
    {
        if (is_numeric($item)) {
            $obj['examinee_id'] = $item;
            $col = 1;
        }
        else {
            switch ($col) {
                case 1:
                    $obj['name_of_examinee'] = $item;
                    $col++;
                    break;
                case 2:
                    $obj['campus_eligibility'] = $item;
                    $col++;
                    break;
                case 3:
                    $obj['school'] = $item;
                    $col++;
                    break;
                case 4:
                    $obj['division'] = $item;
                    $col++;
                    break;
                default:
                    break;
            }                
        }

        if ($col == 5) {
            DB::table('passers')->insert($obj);
            $this->col = 0;
            $this->obj = array();
        }
        else {
            $this->col = $col;
            $this->obj = $obj;
        }
    }

    private function dump_scrape($item,$row,$col,$obj)
    {
        if (is_numeric($item)) {
            $col = 0;
            $obj[$row][$col] = $item;

            $col++;
        }
        else {
            switch ($col) {
                case 1:
                    $obj[$row][$col] = $item;
                    $col++;
                    break;
                case 2:
                    $obj[$row][$col] = $item;
                    $col++;
                    break;
                case 3:
                    $obj[$row][$col] = $item;
                    $col++;
                    break;
                case 4:
                    $obj[$row][$col] = $item;
                    $col++;
                    break;
                default:
                    break;
            }                
        }

        if ($col == 5) {
            $row++;
        }

        $this->row = $row;
        $this->col = $col;
        $this->obj = $obj;
    }

    private function save_dump_scrape()
    {
        foreach($this->obj as $record) {

            $items = array();

            foreach($record as $key => $val) {
                switch ($key) {
                    case 0:                
                        $items['examinee_id'] = $val;
                        break;
                    case 1:
                        $items['name_of_examinee'] = $val;
                        break;
                    case 2:
                        $items['campus_eligibility'] = $val;
                        break;
                    case 3:
                        $items['school'] = $val;
                        break;
                    case 4:
                        $items['division'] = $val;
                        break;
                    default:
                        break;
                }
            }

            DB::table('passers')->insert($items);
        }
    }
}
