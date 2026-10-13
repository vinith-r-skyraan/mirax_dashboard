<?php

namespace App\Services;

class WorkoutPlanService
{
    public static function getPlan(string $name): array
    {
        $name = strtolower($name);

        if (str_contains($name, 'weight')) {
            return self::weightLoss();
        }

        if (str_contains($name, 'muscle')) {
            return self::muscleGain();
        }

        return self::fitness();
    }

    private static function weightLoss(): array
    {
        return [
            1 => ['HIIT Cardio', 'Treadmill + Jump Rope'],
            2 => ['Abs & Core', 'Planks, Crunches'],
            3 => ['Lower Body', 'Squats, Lunges'],
            4 => ['Upper Body', 'Pushups, Rows'],
            5 => ['Fat Burn Cardio', 'Cycling'],
            6 => ['Yoga', 'Stretch & Balance'],
            7 => ['Active Rest', 'Walking'],
        ];
    }

    private static function muscleGain(): array
    {
        return [
            1 => ['Chest', 'Bench Press'],
            2 => ['Back', 'Pullups'],
            3 => ['Legs', 'Squats'],
            4 => ['Shoulders', 'Press'],
            5 => ['Arms', 'Biceps & Triceps'],
            6 => ['Core', 'Abs'],
            7 => ['Rest', 'Recovery'],
        ];
    }

    private static function fitness(): array
    {
        return [
            1 => ['Full Body', 'Light weights'],
            2 => ['Cardio', 'Running'],
            3 => ['Core', 'Abs'],
            4 => ['Strength', 'Compound lifts'],
            5 => ['Stretching', 'Flexibility'],
            6 => ['Cardio', 'Cycling'],
            7 => ['Rest', 'Relax'],
        ];
    }
}
