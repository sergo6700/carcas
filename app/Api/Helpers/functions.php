<?php

if (!function_exists('_strtotime')) {
    /**
     * @param int|string $date
     * @return false|int|string
     */
    function _strtotime($date)
    {
        return is_numeric($date) ? $date : strtotime(str_replace('/', '-', $date));
    }
}

if (!function_exists('carbon')) {
    /**
     * @param $date
     * @return \Carbon\Carbon|null
     */
    function carbon($date)
    {
        return $date ? \Carbon\Carbon::createFromTimestamp(_strtotime($date)) : null;
    }
}

if (!function_exists('_humanize')) {

    /**
     * @param $val
     * @return string
     */
    function _humanize($val)
    {
        $val = str_replace("_", "", $val);
        $matches = preg_split('/(?=[A-Z])/', $val);
        return trim(implode(" ", $matches));
    }
}

if (!function_exists('get_class_constants')) {
    /**
     * returns the list of constants of the given class
     *
     * @param $className
     * @param bool|false $reverse
     * @param bool|true $humanize
     * @return array
     * @throws Exception
     */
    function get_class_constants($className, $reverse = false, $humanize = true)
    {
        if (!class_exists($className)) {
            throw new Exception(sprintf('%s class does not exist', $className));
        }

        $refl = new ReflectionClass($className);
        $constants = $refl->getConstants();

        if ($reverse) {
            $constants = array_flip($constants);

            array_walk($constants, function (&$val, $k) use ($humanize) {
                if ($humanize) {
                    $val = _humanize($val);
                }
            });
        }

        return $constants;
    }
}

if (!function_exists('get_class_constants_string')) {
    /**
     * @param $className
     * @return string
     * @throws Exception
     */
    function get_class_constants_string($className)
    {
        $constants = get_class_constants($className);

        return implode(',', $constants);
    }
}

if (!function_exists('iso_countries_2_letters')) {

    /**
     * @return array
     */
    function iso_countries_2_letters()
    {
        $result = [];

        $countries = (new \Sokil\IsoCodes\IsoCodesFactory())
            ->getCountries()
            ->toArray();

        foreach ($countries as $country) {
            $result[] = [
                'id' => $country->getAlpha2(),
                'name' => $country->getName()
            ];
        }

        return $result;
    }
}

if (!function_exists('iso_countries_3_letters')) {

    /**
     * @return array
     */
    function iso_countries_3_letters()
    {
        $result = [];

        $countries = (new \Sokil\IsoCodes\IsoCodesFactory())
            ->getCountries()
            ->toArray();

        foreach ($countries as $country) {
            $result[] = [
                'id' => $country->getAlpha3(),
                'name' => $country->getName()
            ];
        }

        return $result;
    }
}


if (!function_exists('parse_to_key_value')) {

    /**
     * @param array $data
     * @param null $translation
     * @return array
     */
    function parse_to_key_value(array $data, $translation = null)
    {
        $result = [];

        foreach ($data as $key => $name) {
            $name = !empty($translation) ? trans($translation . '.' . $key) : $name;

            $result[] = [
                'key' => $key,
                'name' => $name,
            ];
        }

        return $result;
    }
}

