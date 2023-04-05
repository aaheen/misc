# Given a time in 12-hour AM/PM format, convert it to military (24-hour) time.
# Note: 12:00:00AM on a 12-hour clock is 00:00:00 on a 24-hour clock.
# Note: 12:00:00PM on a 12-hour clock is 12:00:00 on a 24-hour clock. 

# s is a time of the form hh:mm:ssAM or hh:mm:ssPM
def timeConversion(s):
    # get time values
    times = s.split(':')
    hh = int(times[0])
    mm = int(times[1])
    ss = int(times[2][0:2])
    
    # midnight is 0, noon is 12
    # range is now 0 to 11
    if hh % 12 == 0:
        hh -= 12
    
    # if pm
    ap = s[s.lower().find("M")-1]
    if ap == "P":
        hh = hh + 12
    
    return "{:02d}:{:02d}:{:02d}".format(hh, mm, ss)