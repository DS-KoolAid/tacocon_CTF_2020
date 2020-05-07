# tacosay
Create the binary from the C file
`gcc tacosay.c -o tacosay`

## Solution
Intent is for user to find the correct input to return the flag.

There are two solutions.
1. Step through via a debugger like gdb. You are looking for a strcmp function. Checkout the `.gdb_history` file for the instructions to run
2. Reveal all the library calls the binary makes using `ltrace`. This reveals the call made to strcmp