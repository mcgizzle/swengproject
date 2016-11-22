package swengproject.swengproject;

import android.content.Intent;
import android.os.Bundle;
import android.support.v7.app.AppCompatActivity;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
import android.widget.ProgressBar;

import java.util.ArrayList;

import static swengproject.swengproject.R.layout.add_project;

/**
 * Created by McGroarty on 15/11/2016.
 */

public class AddProjectActivity extends AppCompatActivity {

    final int TYPE = 1;
    private ProgressBar pb;

    @Override
    protected void onCreate(final Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(add_project);

        pb = (ProgressBar)findViewById(R.id.progressBar);
        pb.setVisibility(View.GONE);

        Button submit = (Button) findViewById(R.id.submitButton);
        submit.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                gather_info();
            }
        });
    }

    public void gather_info() {

        ArrayList<String> data = new ArrayList<String>();
        ArrayList<String> meta = new ArrayList<String>();
        meta.add("TYPE");
        data.add(TYPE+"");

        EditText n = (EditText) (findViewById(R.id.editText));
        String name = n.getText().toString();
        meta.add("NAME");
        data.add(name);

        EditText i = (EditText) (findViewById(R.id.editText4));
        String list = i.getText().toString();
        String[] separated = list.split(",");
        meta.add("INDIVIDUALS_NUM");
        data.add(""+separated.length);
        for(int x=0;x<separated.length;x++){
            meta.add("INDIVIDUALS"+x);
            data.add(separated[x]);
        }

        EditText e = (EditText) (findViewById(R.id.editText3));
        String end_date = e.getText().toString();
        meta.add("END_DATE");
        data.add(end_date);


        Intent passData = (new Intent(AddProjectActivity.this, QueryActivity.class));
        passData.putExtra("TYPE",TYPE);
        passData.putExtra("DATA",data);
        passData.putExtra("META_DATA",meta);
        passData.putExtra("ACTIVITY",add_project);
        passData.putExtra("PREVIOUS_ACTIVITY",AddProjectActivity.class);

        startActivity(passData);

    }
}