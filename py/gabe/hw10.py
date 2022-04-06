#problem B

# count_t = 0
# def is_target(lines):
#     if lines == []:
#         if len(count_t) < len(lines): 
#             count_t = []
#             return False
#         else:
#             count_t = []
#             return True
#     else: 
#         if 'A' in lines[0] or 'C' in lines[0] or 'M' in lines[0] or 'E' in lines[0]:
#             count_t.append(lines[0])
#             return is_target(lines[1:])
#         else:
#             return is_target(lines[1:])

def targ_rec(shots):
    # base case
    if shots == []:
        return True

    # not base case, either append and recurse, or return False
    if ('A' in shots[0]) or ('C' in shots[0]) or ('M' in shots[0]) or ('E' in shots[0]):
        return my_target(shots[1:])
    else:
        return False

def targ_for(shots):
    for i in range(len(shots)):
        if not ('A' in shots[i]) or ('C' in shots[i]) or ('M' in shots[i]) or ('E' in shots[i]):
            return False
    return True

def collatz(n):
    if n == 1:
        return 1
    elif n%2 == 0:
        return 1 + collatz(n // 2)
    else:
        return 1 + collatz(n * 3 + 1)