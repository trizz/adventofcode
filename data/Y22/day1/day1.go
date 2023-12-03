package Y22

import (
	"adventofcode/src-go/helpers"
	"sort"
	"strconv"
)

func Day1() helpers.DayResults {
	day1Example := helpers.ReadFileByLine("data/Y22/day1/example.txt")
	day1 := helpers.ReadFileByLine("data/Y22/day1/data.txt")

	calorieCount := calculateCalories(day1Example)
	part1Example := calorieCount[len(calorieCount)-1]
	part2Example := calorieCount[len(calorieCount)-1] + calorieCount[len(calorieCount)-2] + calorieCount[len(calorieCount)-3]

	calorieCount = calculateCalories(day1)
	part1Result := calorieCount[len(calorieCount)-1]
	part2Result := calorieCount[len(calorieCount)-1] + calorieCount[len(calorieCount)-2] + calorieCount[len(calorieCount)-3]

	results := helpers.DayResults{
		Day:          1,
		Year:         2022,
		Part1Example: part1Example,
		Part1:        part1Result,
		Part2Example: part2Example,
		Part2:        part2Result,
	}

	return results
}

func calculateCalories(data []string) []int {
	var calorieCount []int
	total := 0
	for _, line := range data {
		if line == "" {
			calorieCount = append(calorieCount, total)
			total = 0
			continue
		}

		val, err := strconv.Atoi(line)
		if err != nil {
			panic(err)
		}

		total += val
	}

	sort.Slice(calorieCount, func(i, j int) bool {
		return calorieCount[i] < calorieCount[j]
	})

	return calorieCount
}
