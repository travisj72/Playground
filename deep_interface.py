#!/usr/bin/env python3

import sys
import random
import time
import os

######################################################################################
# ** DEEP_INTERFACE **
# Hello, ladies and gentlemen, and welcome to the single most monumental event of your
# entire lives!  Are you tired of working, of kicking off endless builds and
# reconfigurations in the fear that at any moment, your boss might look over your
# shoulder and discover just how lazy you really are?  Well no, you can watch Netflix
# all day in peace with DEEP_INTERFACE.  This script outputs a steady churn of
# pseudo-random command line feed that's just generic enough to be literally anything.
# You can't lose!  Run your "builds", your "tests", or your "network configurations"
# all day if you choose.  With such a tool enabling your laziness, who knows what you
# won't accomplish!
######################################################################################

#Tuneable variables
label_freq = 3 #Relative to the total of all frequencies
wait_freq = 2
cmd_freq = 10
max_wait_time = 5000 #In milliseconds
max_cmd_time = 1500
max_intercmd_time = 1000
max_act_time = 2000
cmd_repeat_cnt = 8 #Number of times a command repeats with modified end values

# System customization info
cwd = os.getcwd()

# Pseudo-random line components

flags_sel = ['-i'+cwd+'/hxxp.cpp,''-i'+cwd+'/include','-i'+cwd+'/sharedlibs','-i'+cwd+'/tools/nfs-mount','-Wfeed='+cwd,'-df', '-ring', '-fPIC', '-action', '-fsck', '-r', '-entail', '-pvX', '-no-stdlib', '-Wall', '-02', '-lno-warning-gen', '--version=3.4.1', '--git-ignore', '--t=2h0m0s', '-s7', '--build-path', '--ghost', '--p=i5', '--Wno-flags', '--i root', '--i admin', '--i user', '--variant', '--prog-no-validate', '--pragma-level=3', '--ipchk', '-putin', '-kgb-addr=172.168.1.1', '-env local', '--sym', '-mE', '-fShared', '-no-ip-config', '-c3p0', '-r2d2']

end_sel = [ './coldstone.conf','./inet.conf', './resolve.conf', './config.conf','./screwball.oracle', './icon.cpp', './http.cpp', './albion.cpp', './nodejs_compat.cpp', './file_proc.cpp', './const.cpp']

waiting_sel = ['...', 'Loading...', '...', 'Please wait...', '...', '...patience...', 'Reading from nfs mount...', '...', 'Checking md5']

done_sel = ['Done.']

thing_sel = ['IP parameter', 'binary load-lifters', 'localhost', 'remote repository', 'kgb-net', 'Windows compatibility distro', 'mscanlan.stash.com', 'ssh-client', 'chao5 server']

binary_sel = ['portsnap', 'nm', 'clang++', 'gcc', 'ps', 'gerryio', 'lol2', 'nets', 'mscan', 'gher', 'dirent', 'chao5', 'pep', 'ccorrel', 'sshnuke']

action_sel = ['Verifying', 'Sanitizing', 'Loading', 'Connecting to', 'Proselytizing to', 'Establishing validity of', 'Recompiling', 'Updating', 'Autodetecting']


def selComponents(comp_list,num=1):
    retList = []
    for i in range(num):
        val = comp_list[random.randint(0, len(comp_list)-1)]
        if val in retList:
            retList.append(val+"-hint 4096")
        else:
            retList.append(val)
    return retList

def waitMilli(approx):
    time.sleep(random.randint(0,approx)/1000)

def do_the_thing():
    choice_string = label_freq*"l" + wait_freq*"w" + cmd_freq*"c"
    while True:
        rand = random.randint(0,label_freq + wait_freq + cmd_freq - 1)
        if choice_string[rand] == 'l': #Label time
            action = selComponents(action_sel)
            thing = selComponents(thing_sel)
            print(action[0] + " " + thing[0])
            waitMilli(max_act_time)
        elif choice_string[rand] == 'w': #Wait time
            waitstr = selComponents(waiting_sel)
            donestr = selComponents(done_sel)
            print(waitstr[0])
            waitMilli(max_wait_time)
            print(donestr[0])
        else: #Command time
            flags = selComponents(flags_sel,random.randint(4, len(flags_sel)//2))
            binary = selComponents(binary_sel)
            for i in range(random.randint(1,cmd_repeat_cnt)):
                end = selComponents(end_sel)
                print(binary[0] + ' ' + ' '.join(flags) + ' ' + end[0])
                waitMilli(max_intercmd_time // random.randint(1, 20))
            waitMilli(max_cmd_time)


if __name__ == '__main__':
    # We are running as a script
    do_the_thing()




