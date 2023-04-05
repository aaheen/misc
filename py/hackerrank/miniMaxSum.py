# Given five positive integers, find the minimum and maximum values that can be
# calculated by summing exactly four of the five integers. Then print the 
# respective minimum and maximum values as a single line of two space-separated 
# long integers. 
def miniMaxSum(arr):
    print(sum(arr) - max(arr), sum(arr) - min(arr))