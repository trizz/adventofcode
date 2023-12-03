package main

import (
	y22 "adventofcode/data/Y22"
	"adventofcode/src-go/helpers"
	"fmt"
	"github.com/fatih/color"
)

func main() {
	runY22()
	day, year := helpers.GetDayYear()

	fmt.Println(day, year)
}

func runY22() {
	color.HiYellow("\n--- Advent of Code 2022 ---\n\n")
	helpers.PrintDayResults(y22.Day1())
	helpers.PrintDayResults(y22.Day2())
}
