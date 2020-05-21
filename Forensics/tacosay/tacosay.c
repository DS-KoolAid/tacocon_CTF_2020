#include <stdio.h>
#include <string.h>
#include <stdbool.h>


bool check_input(char* input) {
   int correct_input_xor[26] = {
        0x03, 0x5f, 0x40, 0x0a, 0x00
    };

    int correct_input_xor_key[26] = {
        0x6e, 0x6f, 0x70, 0x65, 0x21
    };

    char correct_input[27];
    for (int i=0; i<26; i++) {
        char c = (char)((int)correct_input_xor[i] ^ (int)correct_input_xor_key[i]);
        correct_input[i] = c;
    }
    correct_input[26] = '\0';
    if (strcmp(correct_input, input) == 0) {
        return true;
    }
    else {
        return false;
    }
}

int main(int argc, char **argv)
{
    printf("------------------------\n");
    printf("< ");
    if (argc == 1) {
        printf("What does the taco say? ");
    }
    else if (argc == 2) {
        if (check_input(argv[1])) {
            int flag_xor[42] = {
                0x3a, 0x08, 0x00, 0x0a, 0x3c, 0x1b, 0x1c, 0x02, 0x0d, 0x57,
                0x13, 0x06, 0x1d, 0x1e, 0x15, 0x2c, 0x02, 0x0e, 0x07, 0x09,
                0x3a, 0x11, 0x00, 0x10, 0x31, 0x0f, 0x28, 0x01, 0x25, 0x09,
                0x1e, 0x16, 0x2c, 0x0e, 0x1b, 0x00, 0x39, 0x0d, 0x17, 0x1a,
                0x0c, 0x12
            };
            
            int flag_xor_key[42] = {
                0x6e, 0x69, 0x63, 0x65, 0x5f, 0x74, 0x72, 0x79, 0x5f, 0x64,
                0x65, 0x63, 0x6f, 0x6d, 0x70, 0x69, 0x6c, 0x69, 0x6e, 0x67,
                0x5f, 0x74, 0x72, 0x79, 0x5f, 0x68, 0x61, 0x72, 0x64, 0x65,
                0x72, 0x5f, 0x78, 0x6f, 0x78, 0x6f, 0x78, 0x6f, 0x78, 0x6f,
                0x78, 0x6f
            };

            char flag[43];
            for (int i=0; i<42; i++) {
                char c = (char)((int)flag_xor[i] ^ (int)flag_xor_key[i]);
                flag[i] = c;
            }

            flag[42] = '\0';
            printf("It says %s - %s ", argv[1], flag);
        }
        else if (strcmp("Ring-ding-ding-ding-dingeringeding!", argv[1]) == 0) {
            printf("https://www.youtube.com/watch?v=jofNR_WkoCE ");
        }
        else {
            printf("It does not say %s ", argv[1]);
        }
    }
    else {    
        for (int i = 1; i < argc; i++) {
            printf("%s ", argv[i]);
        }
    }
    printf("> 🌮\n");
    printf("------------------------\n");
    printf(" \\   ┈┈┈╱▔▔▔▔▔╲▔╲┈┈┈\n");
    printf("  \\  ┈┈╱┈╭╮┈╭╮┈╲╮╲┈┈\n");
    printf("   \\ ┈┈▏┈▂▂▂▂▂┈▕╮▕┈┈\n");
    printf("     ┈┈▏┈╲▂▂▂╱┈▕╮▕┈┈\n");
    printf("     ┈┈╲▂▂▂▂▂▂▂▂╲╱┈┈\n");
    return (0);
}