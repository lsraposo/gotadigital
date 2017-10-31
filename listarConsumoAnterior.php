
//TRABALHO DE CONCLUSÃO DE CURSO - GOTA DIGITAL

//Autores:
//
//Mailson Marques
//APOIO - Dheyson
//Luciano

<?php

require_once 'DB.php';

        $sql = "SELECT * from (SELECT SUM(vazao) AS LITROS,
                SUM(vazao * 0.001) as ConsumoMes,
                EXTRACT(MONTH FROM evento)as meses,
                (CASE month(evento)
                 when 1 then 'Jan'
                 when 2 then 'Fev'
                 when 3 then 'Mar'
                 when 4 then 'Abr'
                 when 5 then 'Mai'
                 when 6 then 'Jun'
                 when 7 then 'Jul'
                 when 8 then 'Ago'
                 when 9 then 'Set'
                 when 10 then 'Out'
                 when 11 then 'Nov'
                 when 12 then 'Dez'
                 END) AS MES,
                EXTRACT(YEAR FROM evento ) AS ANO
                FROM tbvazao where tbEndereco_idEndereco = 1
                group by MES HAVING ANO = year(now())) as meses
                ORDER by meses desc LIMIT 6" ;

        $stmt = DB::prepare($sql);
        $stmt->bindParam(1, $_POST["idEnd"], PDO::PARAM_INT);
        $stmt->execute();


        $result_json = array();

        while ($row1 = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $sql = "SELECT
                                        cast(sum(
                                                if (idfaixa = 1, valor_agua,
                                                        if (".$row1['ConsumoMes'].">faixa_final, ((faixa_final-faixa_inicial+1)*valor_agua), ((".$row1['ConsumoMes']."-faixa_inicial+1)*valor_agua))
                                                )
                                        ) as decimal(10,2)) as valor_total_agua,
                                        cast(sum(
                                                if (idfaixa = 1, valor_esgoto,
                                                        if (".$row1['ConsumoMes'].">faixa_final, ((faixa_final-faixa_inicial+1)*valor_esgoto), ((".$row1['ConsumoMes']."-faixa_inicial+1)*valor_esgoto))
                                                )
                                        ) as decimal(10,2)) as valor_total_esgoto
                                        FROM tbfaixaaguaesgoto

                                        where faixa_inicial <= ".$row1['ConsumoMes'];


                $stmt2 = DB::prepare($sql);
                $stmt2->execute();

                $sel_row = $stmt2->fetch(PDO::FETCH_ASSOC);
                $total_agua = (double) $sel_row['valor_total_agua'];
                $total_esgoto = (double) $sel_row['valor_total_esgoto'];

                $row1['totalValor'] = $total_agua + $total_esgoto;

                $result_json[] = $row1;

        }


        echo json_encode($result_json);


?>