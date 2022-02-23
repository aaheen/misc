package main

import (
	"fmt"

	"rsc.io/quote"
)

func Hello() {
	fmt.Println("Hello world.")
}

func Quote() {
	fmt.Println(quote.Go())
}

func Greet() {
	var username string
	fmt.Print("What is your name? ")
	fmt.Scanln(&username)
	fmt.Printf("Hello, %s.\n", username)
}

func Ageist() {
	var age int
	fmt.Print("How old are you? ")
	fmt.Scanf("%d", &age)
	ageComment(age)
}

func ageComment(age int) {
	switch {
	case age < 16:
		fmt.Println("You're too young to do anything fun.")
	case 16 <= age && age < 18:
		fmt.Println("You're old enough to drive, but you can't vote.")
	case 18 <= age && age < 21:
		fmt.Println("You can vote but can't drink. I bet that hasn't stopped you from trying though...")
	case 21 <= age && age < 35:
		fmt.Println("You're old enough to drive, vote, and drink, but you can't be president.")
	case 35 <= age:
		fmt.Println("You're old enough to drink, drive, and run for president. Try all three at once!")
	}
}
