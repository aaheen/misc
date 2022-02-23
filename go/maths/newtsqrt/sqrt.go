package main

// Newton's method for finding the square root
// Iterating only 10 times
func NewtSqrtTenloop(x float64) float64 {
	var z float64 = 1.0
	for i := 1; i < 10; i++ {
		z -= (z*z - x) / (2 * z)
	}
	return z
}

// Newton's method for finding the square root
func NewtSqrt(x float64) float64 {
	z := x / 2.0
	for y := (z*z - x) / (2 * z); y >= 0.00000000000001; z -= y {
		y = (z*z - x) / (2 * z)
	}
	return z
}
