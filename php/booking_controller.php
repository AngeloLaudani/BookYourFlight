<?php
// Gestione SUBMIT form
    if (!empty($_POST[ 'token' ])) {
        if (hash_equals($_SESSION[ 'token' ], $_POST[ 'token' ])) {
            if (isset($_POST[ 'selected_cell' ])) {
                $id = $_SESSION[ 'user_id' ];
                $seats = $_POST[ 'selected_cell' ];
                $num = count($seats);
                $k = 0;

                try {
                    mysqli_autocommit($mysqli, false);

                    for ($i = 0; $i < $num; $i++) {
                        $x = $seats[ $i ];
                        $y = $seats[ $i + 1 ];

                        $sql_seats = "UPDATE seats SET status = 'booked' WHERE user_id = $id AND row = $x AND col = '$y' AND status = 'reserved'";
                        if (!$mysqli->query($sql_seats)) {
                            throw new Exception("<div class=\"php-message error\">Booking error, try again!</div>");
                        }
                        // Conto quanti "posti" sto effettivamente prenotando (devono essere riservati e con il mio user_id)
                        if (($mysqli->affected_rows) == 1) {
                          $k++;
                        }
                        $i++;
                    }
                    $response_msg = "<div class=\"php-message success\">Seat booked successfully!</div>";
                    // Se i posti prenotati sono diversi da quanti riservati (in giallo) significa che un altro utente ha riservato un mio posto.
                    if ($i != ($k*2)) {
                        throw new Exception("<div class=\"php-message error\">Your reserved seat has been booked by another user!</div>");
                    }

                    mysqli_commit($mysqli);
                    $_SESSION[ 'timestamp' ] = time();
                    echo $response_msg;
                    
                } catch (Exception $e) {
                    $mysqli->rollback();
                    echo $e->getMessage();

                    for ($i = 0; $i < $num; $i++) {
                        $x = $seats[ $i ];
                        $y = $seats[ $i + 1 ];

                        $sql_seats = "DELETE FROM seats WHERE user_id = $id AND row = $x AND col = '$y' AND status = 'reserved'";
                        if (!$mysqli->query($sql_seats)) {
                            throw new Exception("<div class=\"php-message error\">Booking error, try again!</div>");
                        }
                        $i++;
                    }
                }
                mysqli_autocommit($mysqli, true);
            } else {
                echo "<div class=\"php-message error\">Input Error!</div>";
            }
        } else {
            echo "<div class=\"php-message error\">Session Error!</div>";
        }
    }
