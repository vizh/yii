<?php

class CText
{
    /**
     * https://github.com/excelwebzone/EWZTextBundle/blob/master/Templating/Helper/TextHelper.php
     * Truncates +text+ to the length of +length+ and replaces the last three characters with the +truncate_string+
     * if the +text+ is longer than +length+.
     */
    public static function truncate($text, $length = 30, $truncate_string = '...', $truncate_lastspace = false)
    {
        if ($text == '') {
            return null;
        }

        if (strlen($text) > $length) {
            $truncate_text = substr($text, 0, $length - strlen($truncate_string));

            if ($truncate_lastspace) {
                $truncate_text = preg_replace('/[\s\,\.]+?(\S+)?$/', '', $truncate_text);
            }

            return trim($truncate_text).$truncate_string;
        }

        return $text;
    }

    public static function humanFileSize($file, $retstring = '%01.2f&nbsp;%s', $system = 'si', $max = null)
    {
        if (!file_exists($file)) {
            return '0';
        }

        $size = filesize($file);

        // Pick units
        $systems['si']['prefix'] = ['B', 'K', 'MB', 'GB', 'TB', 'PB'];
        $systems['si']['size'] = 1000;
        $systems[':)']['prefix'] = ['b', 'k', 'mb', 'gb', 'tb', 'pb'];
        $systems[':)']['size'] = 1000;
        $systems['bi']['prefix'] = ['B', 'KiB', 'MiB', 'GiB', 'TiB', 'PiB'];
        $systems['bi']['size'] = 1024;
        $sys = isset($systems[$system]) ? $systems[$system] : $systems['si'];

        // Max unit to display
        $depth = count($sys['prefix']) - 1;
        if ($max && false !== $d = array_search($max, $sys['prefix'])) {
            $depth = $d;
        }

        // Loop
        $i = 0;
        while ($size >= $sys['size'] && $i < $depth) {
            $size /= $sys['size'];
            $i++;
        }

        return sprintf($retstring, $size, $sys['prefix'][$i]);
    }

    /**
     * Генерация поддельного адреса электронной почты
     *
     * @param string $event
     * @param string $domain домен почтового сервера
     * @return string
     */
    public static function generateFakeEmail($event = '', $domain = 'runet-id.com')
    {
        return sprintf('nomail%s+%s@%s',
            $event,
            substr(md5(mt_rand().microtime(true)), 24),
            $domain
        );
    }

    /**
     * Проверяет, что указанный адрес электронной почты не является поддельным
     *
     * @param $email
     * @param string $domain
     * @return bool
     */
    public static function isRealEmail($email, $domain = 'runet-id.com')
    {
        return preg_match("#^nomail.+?@{$domain}$#", $email) === 0;
    }

    /**
     * Заменяет токены в переданном тексте
     * @param $text string
     * @param $params array
     * @return string
     */
    public static function replaceTokens($text, $params)
    {
        foreach ($params as $key => $param) {
            if (is_array($param)) {
                //заменяет блоки {for }
                $pattern = '/(\{for '.$key.'\})(.*)(\{endfor\})/Uims';
                while (true) {
                    preg_match($pattern, $text, $brace_matches, PREG_OFFSET_CAPTURE);
                    if (empty($brace_matches[0])) {
                        break;
                    }

                    $replacement = '';
                    foreach ($param as $sub_param) {
                        $item_replacement = $brace_matches[2][0];
                        foreach ($sub_param as $sub_key => $sub_value) {
                            $item_replacement = preg_replace('/\{'.$sub_key.'\}/Uims', $sub_value, $item_replacement);
                        }
                        $replacement .= $item_replacement;
                    }
                    $text = substr($text, 0, $brace_matches[0][1]) . $replacement . substr($text, $brace_matches[3][1]+strlen('{endfor}'));
                }

                //заменяет параметры массива вне блоков {for }
                //значениями из первого элемента массива
                foreach ($param[0] as $sub_key => $sub_param) {
                    $text = preg_replace('/\{'.$sub_key.'\}/ims', $sub_param, $text);
                }
            } else {
                //заменяет строковый параметр
                $text = preg_replace('/\{'.$key.'\}/ims', $param, $text);
            }
        }
        return $text;
    }
}