using System;
using System.Collections.Generic;
using System.Data.SqlClient;

namespace backend
{
    public class auth
    {
        private string conn_str = "server=localhost;database=osds;user id=root;password=password";

        public bool validate_user(string username, string password, string des_key)
        {
            string query = "select * from users where username=@username and password=@password";
            using (SqlConnection conn = new SqlConnection(conn_str))
            {
                conn.Open();
                using (SqlCommand cmd = new SqlCommand(query, conn))
                {
                    cmd.Parameters.AddWithValue("@username", username);
                    cmd.Parameters.AddWithValue("@password", password);
                    using (SqlDataReader reader = cmd.ExecuteReader())
                    {
                        if (reader.Read())
                        {
                            string stored_key = reader["des_key"].ToString();
                            return stored_key == des_key;
                        }
                    }
                }
            }
            return false;
        }
    }
}
