package main

import "fmt"

func main() {
	var x float64
	fmt.Print("Input number: ")
	fmt.Scanln(&x)
	fmt.Println("Newton's method, guess 1.0, after 10 loops:", NewtSqrtTenloop(x))
	fmt.Println("Newton's method, guess x/2, maximum precision:", NewtSqrt(x))
}
