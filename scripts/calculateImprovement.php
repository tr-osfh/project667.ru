<?php
function calculateImprovement($newValue, $oldValue, $metricName) {
    if ($oldValue == 0) {
        return "";
    }

    $percentageChange = (($newValue - $oldValue) / $oldValue) * 100;

    if ($percentageChange > 0) {
        // Улучшение
        if ($metricName == "скорость") {
            return "Скорость увеличилась на " . round(abs($percentageChange), 2) . "%!";
        } elseif ($metricName == "точность") {
            return "Точность улучшилась на " . round(abs($percentageChange), 2) . "%!";
        } elseif ($metricName == "ошибки") {
            return "Ошибок стало меньше на " . round(abs($percentageChange), 2) . "%!";
        }
    } elseif ($percentageChange < 0) {
        // Ухудшение
        if ($metricName == "скорость") {
            return "Скорость стала меньше на " . round(abs($percentageChange), 2) . "%.";
        } elseif ($metricName == "точность") {
            return "Точность снизилась на " . round(abs($percentageChange), 2) . "%. ";
        } elseif ($metricName == "ошибки") {
            return "Количество ошибок увеличилось на " . round(abs($percentageChange), 2) . "%.";
        }
    } else {
        // Нет изменений
        if ($metricName == "скорость") {
            return "Результаты скорости не поменялись.";
        } elseif ($metricName == "точность") {
            return "Результаты точности остались прежними";
        } elseif ($metricName == "ошибки") {
            return "Количество ошибок не поменялось.";
        }
    }
}

function calculateImprovementV2($newValue, $oldValue, $metricName) {
    if ($oldValue == 0) {
        return "";
    }

    $percentageChange = (($newValue - $oldValue) / $oldValue) * 100;

    if ($percentageChange > 0) {
        // Улучшение
        if ($metricName == "скорость") {
            return "Скорость увеличилась на " . round(abs($percentageChange), 2) . "%!";
        } elseif ($metricName == "точность") {
            return "Точнее на " . round(abs($percentageChange), 2) . "%! ";
        } elseif ($metricName == "ошибки") {
            return "Ты сократил количество ошибок на " . round(abs($percentageChange), 2) . "%!";
        }
    } elseif ($percentageChange < 0) {
        // Ухудшение
        if ($metricName == "скорость") {
            return "Скорость снизилась на " . round(abs($percentageChange), 2) . "%.";
        } elseif ($metricName == "точность") {
            return "Точность упала на " . round(abs($percentageChange), 2) . "%. ";
        } elseif ($metricName == "ошибки") {
            return "Количество ошибок увеличилось на " . round(abs($percentageChange), 2) . "%. ";
        }
    } else {
        // Нет изменений
        if ($metricName == "скорость") {
            return "Результаты скорости не поменялись.";
        } elseif ($metricName == "точность") {
            return "Результаты точности остались прежними";
        } elseif ($metricName == "ошибки") {
            return "Количество ошибок не поменялось.";
        }
    }
}