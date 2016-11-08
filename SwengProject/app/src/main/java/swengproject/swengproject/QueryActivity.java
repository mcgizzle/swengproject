package swengproject.swengproject;

import android.content.Context;
import android.content.Intent;
import android.os.Bundle;
import android.os.StrictMode;
import android.support.v7.app.AppCompatActivity;
import android.util.Log;
import android.widget.Toast;

import java.io.IOException;
import java.io.OutputStreamWriter;
import java.net.HttpURLConnection;
import java.net.URL;
import java.net.URLEncoder;

/**
 * Created by McGroarty on 08/11/16.
 */
public class QueryActivity extends AppCompatActivity {
    final String SERVER_URL = "SERVER URL";

    @Override
    protected void onCreate(final Bundle savedInstanceState){
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_query);                //Sets the XML file

        StrictMode.ThreadPolicy policy = new StrictMode.ThreadPolicy.Builder().permitNetwork().build();
        StrictMode.setThreadPolicy(policy);

        Bundle extras = getIntent().getExtras();                //How to get Data from previous activity
        String data = extras.getString("DATA NAME");
        String data2 = extras.getString("DATA2 NAME");

    }
    /*
    * insertMySQLPost()
    * Params: None
    * Description: Function appends data to URL and attempts to POST data to PHP script
    * Return: Boolean: succesfully entered data
    */

    public boolean insertMySQLPost() throws IOException {

        String DATA_VARIABLE = "";
        String data = URLEncoder.encode("DATA NAME", "UTF-8")
                + "=" + URLEncoder.encode(DATA_VARIABLE, "UTF-8");

        // Send data
        try {
            // Defined URL  where to send data
            URL url = new URL(SERVER_URL);
            // Send POST data request
            HttpURLConnection conn = (HttpURLConnection) url.openConnection();
            conn.setDoOutput(true);
            OutputStreamWriter wr = new OutputStreamWriter(conn.getOutputStream());
            wr.write(data);
            wr.flush();
            if (conn.getResponseCode() == HttpURLConnection.HTTP_OK) {
                Log.d("Tag", "Success");
            } else {
                Log.d("Tag", "Failure");
                return false;
            }

        }catch(Exception ex) {
            ex.printStackTrace();
            Log.d("Tag", "Failure");
            return false;
        }

        return true;
    }

    /* insertSuccess()
     * Param: None
     * Description: Function is called when the information is successfully sent to the database
     * Return: None
     *
     */
    public void insertSuccess(){
        Context context = getApplicationContext();
        CharSequence text = "Information has been submitted to the database";
        int duration = Toast.LENGTH_LONG;
        Toast toast = Toast.makeText(context, text, duration);
        toast.setMargin(toast.getHorizontalMargin() / 2, toast.getVerticalMargin() / 2);
        toast.show();
        setContentView(R.layout.end_activity);
    }

    /* insertFail()
     * Param: None
     * Description: Function is called when the information is not successfully sent to the database
     * Return: None
     */
    public void insertFail(){
        Context context = getApplicationContext();
        CharSequence text = "Error. Please try again.";
        int duration = Toast.LENGTH_LONG;
        Toast toast = Toast.makeText(context, text, duration);
        toast.setMargin(toast.getHorizontalMargin() / 2, toast.getVerticalMargin() / 2);
        toast.show();
        Intent i = new Intent(QueryActivity.this, MainActivity.class);
        startActivity(i);
    }


}
