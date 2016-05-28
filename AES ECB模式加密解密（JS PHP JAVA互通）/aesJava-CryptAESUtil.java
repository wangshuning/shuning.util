package org.limingnihao.util;

import java.security.Key;
import javax.crypto.Cipher;
import javax.crypto.spec.SecretKeySpec;

import org.apache.commons.codec.binary.Base64;

public class CryptAESUtil {

    private static final String AESTYPE = "AES/ECB/PKCS5Padding";

    public static String AES_Encrypt(String keyStr, String plainText) {
        byte[] encrypt = null;
        try {
            Key key = generateKey(keyStr);
            Cipher cipher = Cipher.getInstance(AESTYPE);
            cipher.init(Cipher.ENCRYPT_MODE, key);
            encrypt = cipher.doFinal(plainText.getBytes());
        } catch (Exception e) {
            e.printStackTrace();
        }
        return new String(Base64.encodeBase64(encrypt));
    }

    public static String AES_Decrypt(String keyStr, String encryptData) {
        byte[] decrypt = null;
        try {
            Key key = generateKey(keyStr);
            Cipher cipher = Cipher.getInstance(AESTYPE);
            cipher.init(Cipher.DECRYPT_MODE, key);
            decrypt = cipher.doFinal(Base64.decodeBase64(encryptData.getBytes()));
        } catch (Exception e) {
            e.printStackTrace();
        }
        return new String(decrypt).trim();
    }

    private static Key generateKey(String key) throws Exception {
        try {
            SecretKeySpec keySpec = new SecretKeySpec(key.getBytes(), "AES");
            return keySpec;
        } catch (Exception e) {
            e.printStackTrace();
            throw e;
        }

    }

    public static void main(String[] args) {

        String keyStr = "UITN25LMUQC436IM";

        String plainText = "this is a string will be AES_Encrypt";

        String encText = AES_Encrypt(keyStr, plainText);
        String decString = AES_Decrypt("1234567890abcdef", "O43cXPV6kHPKPq7xVrvIkZLfBh4eTnlhkZp8qsv9zvk9y875FL9jlCTKRgwfvoUbT79n616qxGTKRAoLQWU153QUz2EHMUKKLXKctG0ZujzGq5wmaXH3hkkuIc//mQRt8JaJSUM39vLhLCL2vclb+aRc7nv8OZuHunbwqHNpqztMv0fU3V+lg/b0T0nmhSMP3eTYc9aqcM1x3jFhdwUVtvZN2HIuqAtGmMT1yK4tGgklywxz8RUthhXeEloBbeSPJDtw4t8+rGz7bTaOujwOydXyOlT87Ch++X7teKuYSqfONrsIEJAH8449nx62NCFQMtBzIKtK5D8CRBr+UrbN4GMKYXdy0XkXUPWpATiFwCoNgeeIDDmkelz9BbImRUbxVNza6LC2VQHdy3B6s1c+qRpBqeyLrxPtHiH7lj/zSkhQ2YDy0DmcazQ36d0He9eCVu4NcO059/qSn+tD0eG8IWzlXEfCkpJG2WLFtwHvoHvxGFZ85WHWerPHxPzke7EfE/HXSZRpCThbgwCDJqgEY2oqKEfWero5LAGDIsaSiKLXktXtXbgz7axRV9zZnENaTDuCqwgIp12oxpByU7D+FA==");

        System.out.println(encText);
        System.out.println(decString);
    }
}
