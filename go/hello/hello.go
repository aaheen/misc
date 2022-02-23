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

func main() {
	Hello()
	//fmt.Println("Hello world.")
	Quote()
	//fmt.Println(quote.Go())
}
