using System;
using System.Collections.Generic;
using System.Linq;
using System.Data.SqlClient;

namespace backend
{
    public class db_operations
    {
        private string conn_str = "server=localhost;database=osds;user id=root;password=password";

        public void insert_record(string table, Dictionary<string, string> data)
        {
            string columns = string.Join(",", data.Keys);
            string values = string.Join(",", data.Keys.Select(key => $"@{key}"));
            string query = $"INSERT INTO {table} ({columns}) VALUES ({values})";

            using (SqlConnection conn = new SqlConnection(conn_str))
            {
                conn.Open();
                using (SqlCommand cmd = new SqlCommand(query, conn))
                {
                    foreach (var pair in data)
                    {
                        cmd.Parameters.AddWithValue($"@{pair.Key}", pair.Value);
                    }
                    cmd.ExecuteNonQuery();
                }
            }
        }

        public List<Dictionary<string, object>> select_records(string table, string condition = "")
        {
            string query = $"SELECT * FROM {table}";
            if (!string.IsNullOrEmpty(condition))
            {
                query += $" WHERE {condition}";
            }

            var result = new List<Dictionary<string, object>>();

            using (SqlConnection conn = new SqlConnection(conn_str))
            {
                conn.Open();
                using (SqlCommand cmd = new SqlCommand(query, conn))
                {
                    using (SqlDataReader reader = cmd.ExecuteReader())
                    {
                        while (reader.Read())
                        {
                            var row = new Dictionary<string, object>();
                            for (int i = 0; i < reader.FieldCount; i++)
                            {
                                row[reader.GetName(i)] = reader.GetValue(i);
                            }
                            result.Add(row);
                        }
                    }
                }
            }
            return result;
        }
    }
}
