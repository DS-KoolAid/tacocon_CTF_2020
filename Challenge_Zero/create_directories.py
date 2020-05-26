import pathlib
import sys

mode = 0o777
root = 'secret_files'

level_one_and_two = ['a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z']
level_three = ['a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm']
level_four =  ['n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z']
level_five = ['a', 'b']

for l1 in level_one_and_two:
    for l2 in level_one_and_two:
        for l3 in level_three:
            for l4 in level_four:
                for l5 in level_five:
                    path = f'{root}/{l1}/{l2}/{l3}/{l4}/{l5}'
                    print(path)
                    pathlib.Path(path).mkdir(mode=mode, parents=True, exist_ok=True)