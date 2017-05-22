import javax.swing.*;
import java.awt.event.*;
 
 
class Main implements ActionListener
{
	// gui aken
    JFrame f;

    // gui tekstiväli
    JTextField t;

    //nupud
    JButton button_1,button_2,button_3,button_4,button_5,button_6,button_7,button_8,button_9,button_0,button_div,button_mul,button_subs,button_add,button_dec,button_eq,delete,clear;
 	
 	//muutujad
    static double a=0,b=0,result=0;
    static int operator=0;
 
    Main()
    {

    	//akna, tekstivälja ja nupude loomine ning parameetrid
        f=new JFrame("Kalkulaator");
        t=new JTextField();
        button_1=new JButton("1");
        button_1.setBorderPainted(true);
        button_1.setFocusPainted(true);
        button_1.setContentAreaFilled(false);
        button_2=new JButton("2");
        button_2.setBorderPainted(true);
        button_2.setFocusPainted(true);
        button_2.setContentAreaFilled(false);
        button_3=new JButton("3");
        button_3.setBorderPainted(true);
        button_3.setFocusPainted(true);
        button_3.setContentAreaFilled(false);
        button_4=new JButton("4");
        button_4.setBorderPainted(true);
        button_4.setFocusPainted(true);
        button_4.setContentAreaFilled(false);
        button_5=new JButton("5");
        button_5.setBorderPainted(true);
        button_5.setFocusPainted(true);
        button_5.setContentAreaFilled(false);
        button_6=new JButton("6");
        button_6.setBorderPainted(true);
        button_6.setFocusPainted(true);
        button_6.setContentAreaFilled(false);
        button_7=new JButton("7");
        button_7.setBorderPainted(true);
        button_7.setFocusPainted(true);
        button_7.setContentAreaFilled(false);
        button_8=new JButton("8");
        button_8.setBorderPainted(true);
        button_8.setFocusPainted(true);
        button_8.setContentAreaFilled(false);
        button_9=new JButton("9");
        button_9.setBorderPainted(true);
        button_9.setFocusPainted(true);
        button_9.setContentAreaFilled(false);
        button_0=new JButton("0");
        button_0.setBorderPainted(true);
        button_0.setFocusPainted(true);
        button_0.setContentAreaFilled(false);
        button_div=new JButton("/");
        button_div.setBorderPainted(true);
        button_div.setFocusPainted(true);
        button_div.setContentAreaFilled(false);
        button_mul=new JButton("*");
        button_mul.setBorderPainted(true);
        button_mul.setFocusPainted(true);
        button_mul.setContentAreaFilled(false);
        button_subs=new JButton("-");
        button_subs.setBorderPainted(true);
        button_subs.setFocusPainted(true);
        button_subs.setContentAreaFilled(false);
        button_add=new JButton("+");
        button_add.setBorderPainted(true);
        button_add.setFocusPainted(true);
        button_add.setContentAreaFilled(false);
        button_dec=new JButton(".");
        button_dec.setBorderPainted(true);
        button_dec.setFocusPainted(true);
        button_dec.setContentAreaFilled(false);
        button_eq=new JButton("=");
        button_eq.setBorderPainted(true);
        button_eq.setFocusPainted(true);
        button_eq.setContentAreaFilled(false);
        delete=new JButton("Delete");
        delete.setBorderPainted(true);
        delete.setFocusPainted(true);
        delete.setContentAreaFilled(false);
        clear=new JButton("Clear");
        clear.setBorderPainted(true);
        clear.setFocusPainted(true);
        clear.setContentAreaFilled(false);
        
        //suurused ning paigutamine
        t.setBounds(30,40,280,30);
        button_7.setBounds(40,100,50,40);
        button_8.setBounds(110,100,50,40);
        button_9.setBounds(180,100,50,40);
        button_div.setBounds(250,100,50,40);
        
        button_4.setBounds(40,170,50,40);
        button_5.setBounds(110,170,50,40);
        button_6.setBounds(180,170,50,40);
        button_mul.setBounds(250,170,50,40);
        
        button_1.setBounds(40,240,50,40);
        button_2.setBounds(110,240,50,40);
        button_3.setBounds(180,240,50,40);
        button_subs.setBounds(250,240,50,40);
        
        button_dec.setBounds(40,310,50,40);
        button_0.setBounds(110,310,50,40);
        button_eq.setBounds(180,310,50,40);
        button_add.setBounds(250,310,50,40);
        
        delete.setBounds(40,380,120,40);
        clear.setBounds(180,380,120,40);
        

        //aknale lisamine
        f.add(t);
        f.add(button_7);
        f.add(button_8);
        f.add(button_9);
        f.add(button_div);
        f.add(button_4);
        f.add(button_5);
        f.add(button_6);
        f.add(button_mul);
        f.add(button_1);
        f.add(button_2);
        f.add(button_3);
        f.add(button_subs);
        f.add(button_dec);
        f.add(button_0);
        f.add(button_eq);
        f.add(button_add);
        f.add(delete);
        f.add(clear);
        

        //akna parameetrid
        f.setLayout(null);
        f.setVisible(true);
        f.setSize(350,480);
        f.setDefaultCloseOperation(JFrame.EXIT_ON_CLOSE);
        f.setResizable(false);
        
        //listenerid
        button_1.addActionListener(this);
        button_2.addActionListener(this);
        button_3.addActionListener(this);
        button_4.addActionListener(this);
        button_5.addActionListener(this);
        button_6.addActionListener(this);
        button_7.addActionListener(this);
        button_8.addActionListener(this);
        button_9.addActionListener(this);
        button_0.addActionListener(this);
        button_add.addActionListener(this);
        button_div.addActionListener(this);
        button_mul.addActionListener(this);
        button_subs.addActionListener(this);
        button_dec.addActionListener(this);
        button_eq.addActionListener(this);
        delete.addActionListener(this);
        clear.addActionListener(this);
    }
 
    public void actionPerformed(ActionEvent e)
    {
        if(e.getSource()==button_1)
            t.setText(t.getText().concat("1"));
        
        if(e.getSource()==button_2)
            t.setText(t.getText().concat("2"));
        
        if(e.getSource()==button_3)
            t.setText(t.getText().concat("3"));
        
        if(e.getSource()==button_4)
            t.setText(t.getText().concat("4"));
        
        if(e.getSource()==button_5)
            t.setText(t.getText().concat("5"));
        
        if(e.getSource()==button_6)
            t.setText(t.getText().concat("6"));
        
        if(e.getSource()==button_7)
            t.setText(t.getText().concat("7"));
        
        if(e.getSource()==button_8)
            t.setText(t.getText().concat("8"));
        
        if(e.getSource()==button_9)
            t.setText(t.getText().concat("9"));
        
        if(e.getSource()==button_0)
            t.setText(t.getText().concat("0"));
        
        if(e.getSource()==button_dec)
            t.setText(t.getText().concat("."));
        
        if(e.getSource()==button_add)
        {
            a=Double.parseDouble(t.getText());
            operator=1;
            t.setText("");
        } 
        
        if(e.getSource()==button_subs)
        {
            a=Double.parseDouble(t.getText());
            operator=2;
            t.setText("");
        }
        
        if(e.getSource()==button_mul)
        {
            a=Double.parseDouble(t.getText());
            operator=3;
            t.setText("");
        }
        
        if(e.getSource()==button_div)
        {
            a=Double.parseDouble(t.getText());
            operator=4;
            t.setText("");
        }
        
        if(e.getSource()==button_eq)
        {
            b=Double.parseDouble(t.getText());
        
            switch(operator)
            {
                case 1: result=a+b;
                    break;
        
                case 2: result=a-b;
                    break;
        
                case 3: result=a*b;
                    break;
        
                case 4: result=a/b;
                    break;
        
                default: result=0;
            }
        
            t.setText(""+result);
        }
        
        if(e.getSource()==clear)
            t.setText("");
        
        if(e.getSource()==delete)
        {
            String s=t.getText();
            t.setText("");
            for(int i=0;i<s.length()-1;i++)
            t.setText(t.getText()+s.charAt(i));
        }        
    }
 
    public static void main(String...s)
    {
        new Main();
    }
}