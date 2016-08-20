<?php
/**
 * @param array $elements
 * @param null $parentId
 * @return array
 * @inputExample
    array(
        0 => array(
            "id" => 1,
            "name" => "First",
            "parent_id" => null
        ),
        1 => array(
            "id" => 2,
            "name" => "Second",
            "parent_id" => 1

        ),
        2 => array(
            "id" => 3,
            "name" => "third",
            "parent_id" => 1
        ),
        3 => array(
            "id" => 4,
            "name" => "4th",
            "parent_id" => 2
        ),
        array(
            "id" => 5,
            "name" => "5th",
            "parent_id" => 3
        )
    );
*/

function buildParentChildTree(array $elements, $parentId = null)
{
    $branch = array();
    foreach ($elements as $element) {
        if ($element['parent_id'] == $parentId) {
            $children = buildParentChildTree($elements, $element['id']);
            if ($children) {
                $element['children'] = $children;
            }
            $branch[] = $element;
        }
    }

    return $branch;
}

/**
 * @param $array
 * @return array
 */
function traverseMultilevelArrayInone($array)
{
    $result = [];
    foreach ($array as $key => $val) {
        if (!empty($val['children'])) {
            $duplicate = $val;
            unset($duplicate['children']);
            $result[] = $duplicate;
            $result = array_merge($result, traverseMultilevelArrayInone($val['children']));
        } else {
            $result[] = $val;
        }
    }

    return $result;
}

/**
 * sksort | function to sort array by its sub array key
 * @param $array Array to be sorted passed by reference.
 * @param string $subkey | key in the sub array which we want to use for sorting
 * @param string $sort_order | sort order default descending
 *
 */

function sksort(&$array, $subkey = "improvement", $sort_order = "desc")
{

    if (count($array))
        $temp_array[key($array)] = array_shift($array);

    foreach ($array as $key => $val) {
        $offset = 0;
        $found = false;
        foreach ($temp_array as $tmp_key => $tmp_val) {
            if (!$found and strtolower($val[$subkey]) > strtolower($tmp_val[$subkey])) {
                $temp_array = array_merge((array)array_slice($temp_array, 0, $offset),
                    array($key => $val),
                    array_slice($temp_array, $offset)
                );
                $found = true;
            }
            $offset++;
        }
        if (!$found) $temp_array = array_merge($temp_array, array($key => $val));
    }

    if ($sort_order == 'asc') $array = array_reverse($temp_array);

    else $array = $temp_array;
}

/** This function takes the transpose of the two dimensional array
 * @param $data
 * @return mixed
 */
function take_assoc_transpose($data)
{
    $first_column = array_keys($data[0]);
    array_unshift($data, null);
    $rest_of_columns = call_user_func_array('array_map', $data);
    foreach ($first_column as $key => $val) {
        array_unshift($rest_of_columns[$key], $val);
    }
    return $rest_of_columns;
}
