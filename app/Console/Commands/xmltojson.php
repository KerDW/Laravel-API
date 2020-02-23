<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class xmltojson extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'xml:json {input_file_name} {output_file_name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Convert xml to json';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $input_file_name = $this->argument('input_file_name').'.xml';
        $output_file_name = $this->argument('output_file_name').'.json';

        $xml_string = Storage::get($input_file_name);
        $xml = new JsonSerializer($xml_string);
        $json = json_encode($xml, JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE);
        Storage::put($output_file_name, $json);
    }
}

class JsonSerializer extends \SimpleXmlElement implements \JsonSerializable
{
    const ATTRIBUTE_INDEX = "@attr";
    const CONTENT_NAME = "_text";

    /**
     * SimpleXMLElement JSON serialization
     *
     * @return array
     *
     * @link http://php.net/JsonSerializable.jsonSerialize
     * @see JsonSerializable::jsonSerialize
     * @see https://stackoverflow.com/a/31276221/36175
     */
    function jsonSerialize()
    {
        $array = [];

        if ($this->count()) {
            // serialize children if there are children
            /**
             * @var string $tag
             * @var JsonSerializer $child
             */
            foreach ($this as $tag => $child) {
                $temp = $child->jsonSerialize();
                $attributes = [];

                foreach ($child->attributes() as $name => $value) {
                    $attributes["$name"] = (string) $value;
                }

                if($attributes)
                    $array[$tag][] = array_merge($temp, [self::ATTRIBUTE_INDEX => $attributes]);
                else
                    $array[$tag][] = $temp;
            }
        } else {
            // serialize attributes and text for a leaf-elements
            $temp = (string) $this;

            // if only contains empty string, it is actually an empty element
            if (trim($temp) !== "") {
                $array[self::CONTENT_NAME] = $temp;
            }
        }

        if ($this->xpath('/*') == array($this)) {
            // the root element needs to be named
            $array = [$this->getName() => $array];
        }

        return $array;
    }
}

