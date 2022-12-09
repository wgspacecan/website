<?php

// Generate Entropy
$length  = 256; // How many bits of entropy you want
$urandom = fopen('/dev/urandom', 'r');
$bytes   = fread($urandom, $length/8);  // Get raw bytes (8 bits in a byte)
$entropy = str_pad(gmp_strval(gmp_init(bin2hex($bytes), 16), 2), $length, "0", STR_PAD_LEFT); // Convert to binary (10110111...) (pad zeros)
#echo "entropy: $entropy".PHP_EOL;

// 1. Create Checksum
$size = strlen($entropy) / 32; // 1 bit of checksum for every 32 bits of entropy
$hex = str_pad(gmp_strval(gmp_init($entropy, 2), 16), strlen($entropy)/8*2, "0", STR_PAD_LEFT); // convert entropy back to hexadecimal ready to be hashed
$hash = hash("sha256", hex2bin($hex)); // hash raw binary of entropy (bin > hex > rawbinary)
$checksum = substr(str_pad(gmp_strval(gmp_init($hash, 16), 2), 256, "0", STR_PAD_LEFT), 0, $size); // hex > dec > bin, pad with zeros, take size bits
#echo "checksum: $checksum".PHP_EOL;

// 2. Combine and split in to groups of 11 bits (32 bits + 1 bit entropy will always be a multiple of 11)
$pieces = str_split($entropy.$checksum, 11);

// 3. Get the wordlist as an array
$wordlist = file("wordlist.txt", FILE_IGNORE_NEW_LINES); // file() reads file in to an array

// 4. Convert groups of 11 bits in to decimal and store the corresponding word
$words = [];
foreach ($pieces as $piece) {
    $i = bindec($piece); // e.g. 01101010011 => 851
    $words[] = $wordlist[$i];
}
$mnemonic = implode(" ", $words); // Convert to a sentence (string of words separated by spaces)
echo "mnemonic: $mnemonic".PHP_EOL;

?>