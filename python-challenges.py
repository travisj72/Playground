my_dictionary = {
    "TiMe" : "Flies..",
    "tHiNg" : "to do",
    "YEAR" : 2019,
    "day" : "Monday"
}

# Attempt #1
def print_dictionary_key(key_in):
    key_in_temp = key_in
    for key in my_dictionary:
        key_temp = key
        if key_in.lower() == key.lower():
            x = my_dictionary[key_temp]
            return x
    print("Do you want to add this key? (Y/N)")
    answer = input()
    if answer.lower() == "y":
        print("What do you want your new value to be?")
        new_val = input()
        my_dictionary[key_in_temp] = new_val
        return "Key has been added."
    return "Key Does not Exist"

def find_key():
    run = True

    while(run):
        print("Enter a key: (or end to exit)")
        key = input()
        if key == "end":
            run = False
            print("Goodbye.")
        else:
            y = print_dictionary_key(key)
            print(y)


# Attempt #2
def case_insensitive_dict(dictionary):
    keys = dictionary.keys()
    for key in keys:
        key_old = key
        dictionary[key.lower()] = dictionary.pop(key_old)
    return dictionary

run = True
while(run):
    sure = case_insensitive_dict(my_dictionary)
    print("Enter a key: (Or end to exit)")
    some_FoRm_OF_kEy = input()
    if some_FoRm_OF_kEy != "end":
        why_not = sure[some_FoRm_OF_kEy]
        print(why_not)
    else:
        run = False
        print("Goodbye.")