def display(c,s=3):         # to display matrix on square board

    h = ' ---'
    for i in range(0,s):
        print(h*s)
        v = []
        for j in range(0, s):
            v.append('| '+ str(c[i][j]) + ' ')
        for m in v:
            print(m,end='')
        print('|')
    print(h*s)


# function to check if there is winner
def check1(a):
    if a[0][0] == a[1][1] == a[2][2] != ' ':      # to check \ diagonal
        return a[0][0]
    elif a[0][2] == a[1][1] == a[2][0] != ' ':    # to check / diagonal
        return a[1][1]
    else:
        for x in range(0,3):
            if a[x][0]==a[x][1]==a[x][2]!=' ':    # to check ___ row
                return a[x][0]
            elif a[0][x]==a[1][x]==a[2][x]!=' ':  # to check | column
                return a[0][x]
            else:
                continue
        return ' '                                # no winner


# function asks input and updates matrix accordingly
def player(m,j):
    entry = ''
    if j%2 == 0:
        entry = 'X'
        print("Player #X's turn")
    else:
        entry = 'O'
        print("Player #O's turn")
    loc = 0
    loc = input("Enter Row, Column coordinates(1/2/3,1/2/3) to place your '" + entry + "': ")
    loc = loc.strip().split(',')
    r, c = int(loc[0]), int(loc[1])

    if r>3 or c>3:
        print('invalid co-ordinates')
        player(m,j)
    elif m[r-1][c-1] != ' ':
        print("this coordinate is already taken")
        player(m,j)
    else:
        m[r - 1][c - 1] = entry

    return m


# final result Print function
def final(r):
    if r == " ":
        print('No Winner')
    print("Game Over")


# Main thread
if __name__ == "__main__":

    matrix = [[' ', ' ', ' '], [' ', ' ', ' '], [' ', ' ', ' ']]
    result = ' '
    print('\nWelcome to Tic-Tac-Toe game\n____________________________\n')
    display(matrix)
    for i in range(0,9):        # Max slots are 9 for 3X3 game

        matrix = player(matrix, i)
        display(matrix)
        result = check1(matrix)
        if result != ' ':
            print('player ', result, 'is winner!!')
            break
    final(result)