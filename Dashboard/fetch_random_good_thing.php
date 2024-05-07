<?php
include 'connect_db.php';

function fetchRandomGoodThing()
{
    global $conn;
    $sql = "SELECT *
            FROM ( SELECT FLOOR(RAND() * 
                                ((SELECT COUNT(*)
                                  FROM good_and_bad_things
                                  WHERE userHandle = 'munna' AND type = 1 ))) AS idx) AS random_idx
            LEFT JOIN
            (   SELECT ROW_NUMBER() OVER () -1 AS index_number, gbt.*
                FROM good_and_bad_things AS gbt
                WHERE userHandle = 'munna' AND type = 1) as ntb
            ON random_idx.idx = ntb.index_number;";

    $result = mysqli_query($conn, $sql);
    $oneGdThing = mysqli_fetch_assoc($result);
    mysqli_free_result($result);
    return $oneGdThing;
}

$oneGdThing = fetchRandomGoodThing(); 

echo htmlspecialchars($oneGdThing['details']); 

mysqli_close($conn);
