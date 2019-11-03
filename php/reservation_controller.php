<?php
include './dbcontroller.php';
session_start();
$idletime = 120;

if (isset($_SESSION[ 'timestamp' ])) {
    if (time() - $_SESSION[ 'timestamp' ] < $idletime) {
        // Gestione POST AJAX
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['row']) && isset($_POST['col'])) {
            $id = $_SESSION[ 'user_id' ];
            $row = $_POST['row'];
            $col = $_POST['col'];

            try {
                mysqli_autocommit($mysqli, false);

                $selected_seat = $mysqli->query("SELECT user_id, row, col, status FROM seats WHERE row = $row AND col = '$col' FOR UPDATE");

                // Se il posto non è presente nel db allora "prenota"
                if (mysqli_num_rows($selected_seat) == 0) {
                    $sql_seat = "INSERT INTO seats (user_id, row, col, status) "
            . "VALUES ('$id','$row','$col', 'reserved')";
                    $response_msg = "<div class=\"php-message success\">Seat reserved successfully!</div>";
                }

                if (mysqli_num_rows($selected_seat) > 0) {
                    $seat = mysqli_fetch_array($selected_seat);

                    // Se il posto è prenotato dal medesimo utente "cancella" (secondo click su posto giallo)
                    if ($seat['user_id'] == $id && $seat['status'] == 'reserved') {
                        $sql_seat = "DELETE FROM seats WHERE user_id = $id AND row = $row AND col = '$col' AND status = 'reserved'";
                        $response_msg = "<div class=\"php-message success\">Seat reservation canceled!</div>";
                    }

                    // Se il posto è prenotato da un altro utente (arancione) allora "prenota" (aggiorna id prenotazione)
                    if ($seat['user_id'] != $id && $seat['status'] == 'reserved') {
                        $other_id = $seat['user_id'];
                        $sql_seat = "UPDATE seats SET user_id = $id WHERE user_id = $other_id AND row = $row AND col = '$col' AND status = 'reserved'";
                        $response_msg = "<div class=\"php-message success\">Seat reserved successfully!</div>";
                    }

                    // Se il posto è acquistato segnala errore ed annulla prenotazione
                    if ($seat['status'] == 'booked') {
                        throw new Exception("<div class=\"php-message error\">Seat already booked!</div>");
                    }
                }

                if (!$mysqli->query($sql_seat)) {
                    throw new Exception("<div class=\"php-message error\">Booking error, try again!</div>");
                }

                mysqli_commit($mysqli);
                mysqli_free_result($selected_seat);
                $_SESSION[ 'timestamp' ] = time();
                echo json_encode(array("response" => $response_msg));
            } catch (Exception $e) {
                $mysqli->rollback();
                echo json_encode(array("exception" => $e->getMessage()));
            }
            mysqli_autocommit($mysqli, true);
        }
    } else {
        echo json_encode(array("redirect" => "login.php"));
    }
}
    // Gestione GET AJAX
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        if (isset($_GET[ 'dummy' ])) {
            $id = 0000000;
        } elseif (isset($_SESSION[ 'user_id' ])) {
            $id = $_SESSION[ 'user_id' ];
        }

        try {
            $stat_seats = $mysqli->query("SELECT user_id, row, col, status FROM seats FOR UPDATE");
            $booked=0;
            $reserved_you=0;
            $reserved_other=0;
            $total=0;

            foreach ($stat_seats as $seat) {
                if ($seat['status'] == 'booked') {
                    $booked++;
                }
                if ($seat['status'] == 'reserved' && $seat['user_id'] == $id) {
                    $reserved_you++;
                }
                if ($seat['status'] == 'reserved' && $seat['user_id'] != $id) {
                    $reserved_other++;
                }
                $total++;
            }
            mysqli_free_result($stat_seats);
            echo json_encode(array("total_seats" => $total_seats, "total" => $total, "booked" => $booked, "reserved_you" => $reserved_you, "reserved_other" => $reserved_other));
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
