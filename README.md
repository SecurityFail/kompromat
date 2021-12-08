Kompromat
=========

This repository collects private keys or their parameters for auditing purposes.

Contributions
=============

Any contribution is welcome, but should follow the following rough guidelines:

Naming:
-------

- Files should have descriptive names.
  - If a single or only few files belong to a set of keys, give them a proper name like "Cisco_ASA_v0.8.15"
  - If the set of keys has proper names in the source set, please try to stick to them (e.g. source names provide vendor+product information)
  - If the set of keys is more or less indistinguishable in itself (e.g. Debian OpenSSL Weak Keys) use their fingerprint for naming
    - Use the fingerprint that is most natural (e.g. hex MD5 for SSH)
    - Certificates should go SHA-256 or SHA-512 for the fingerprint
    - If the parameter for generation are known (e.g. PID for Debian OpenSSL Weak keys) it's recommended to include them
- Files should carry an extension indicating their content:
  - *.key is reserved for private keys in PEM-encoded key format
    - please avoid raw RSA keys (use unencrypted PKCS#8)
    - include the OID of the key used
  - *.crt is reserved for X.509 certificates using PEM encoding
  - *.cer is reserved for X.509 certificates using DER encoding (deprecated)
  - *.pgp is reserved for OpenPGP data streams following RFC 4880 or any of its extensions
    If private keys are included there should be some information providing the password for decryption
  - *.meta holds metadata for the files carrying the same name
    If information refers to a whole directory, an additional entry "applies_to=directory" should be present
- File and directory names should not include space characters
  - It is recommended to stick to alpha-numerics, dash and underscore (dot is acceptable if not the first character
  - Use of uppercase and lowercase letters is possible, but lowercase should be preferred
  - If uppercase and lowercase letters are mixed they MUST still create unique names if filenames where compared case-insensitively
- The directory structure should be used to group files from similar incidents/categories. If a vendor fucks up twice, files should go into the same directory.

Metadata:
---------

Metadata is provided for each set of keys and should contain the following information as applicable:

- The uri= key providing a link from where this key might be obtained. Providing multiple entries is possible
- The vendor= key containing information about the affected vendor
- The product= key describing the affected product
- The applies_to= key if this .meta file describes multiple files
- The applies_mask= entry containing the file mask to which this applies.
  - <FIELD> within the value mean the matching part of the filename provides the information with that name (e.g. <vendor> gives the vendor)
  - {NN} after a field designator provides its (maximum) length
  - <FP-MD5>, <FP-SHA1>, <FP-SHA256>, etc. assumes the fingerprint of that file (e.g. <FP-MD5>-<PID>.* provides the mask used for the Debian OpenSSL Weak Keys)
- The password= key provides the decryption password for encrypted files if necessary (deprecated)

Sources:
--------

This is a project for auditing. Thus please avoid keys that are still in production.
It's NOT the purpose of this project to backup your production keys!

If contributing to this project you should do so responsibly:
BEFORE SUBMITTING KEYS TRY TO REVOKE THEM OR GET THEM REVOKED as appropriate. TIA.

Apart from this:
- Document sources as much as possible so others can reproduce
- If there are accompanying documents (e.g. certificates, chains)to a key it's preferable to include those as well
- Make things machine-readable as much as possible
