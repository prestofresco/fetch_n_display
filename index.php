<!DOCTYPE html> 
<body> 
 <!-- pull jquery JS and CSS references -->
<script type="text/javascript" src="https://code.jquery.com/jquery-3.7.0.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css" crossorigin="anonymous">

<?php

$dresses = array(); // will be our nested array

// looping our API call to pull dresses with ID's 1-100
for ($DRESS_ID = 1; $DRESS_ID <= 100; $DRESS_ID++) {
    $URL = "https://abcd2.projectabcd.com/api/getinfo.php?id=$DRESS_ID";
    $json_data = json_decode(file_get_contents($URL), true);
    $json_data = $json_data["data"];
    // get the fields we need
    $ID = $json_data["id"];
    $NAME = $json_data["name"];
    $DESC_WORD_COUNT = str_word_count($json_data["description"]);
    $DID_YOU_KNOW_COUNT = str_word_count($json_data["did_you_know"]);
    $TOTAL_WORD_COUNT = $DESC_WORD_COUNT + $DID_YOU_KNOW_COUNT;

    // push the values into the nested array using the (keys, values) outlined in the strings below
    array_push($dresses, array("id" => $ID, "name" => $NAME, "desc_word_count" => $DESC_WORD_COUNT, "did_you_know_count" => $DID_YOU_KNOW_COUNT, "total_word_count" => $TOTAL_WORD_COUNT));
}

// encode to json
$dresses = json_encode($dresses);
// var_dump($dresses);

?>

<script>
    // get the dresses json data
    var dresses_json = <?php echo $dresses ?>;

    $(document).ready(function () {
        $('#dresses').DataTable({
            data: dresses_json,
            columns: [
                { data: "id", title: "ID" },
                { data: "name", title: "Name" },
                { data: "desc_word_count", title: "Description Word Count" },
                { data: "did_you_know_count", title: "Did You Know Word Count" },
                { data: "total_word_count", title: "Total Word Count" },
            ]
        });
    });
</script>


<table id="dresses" class="display" style="width:100%">
        <!-- <thead>
            <tr>
                <th>ID</th>
                <th>Description Word Count</th>
                <th>Did You Know Count</th>
                <th>Total Word Count</th>
            </tr>
        </thead> -->
</table>

</body>
</html>


