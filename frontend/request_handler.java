import java.util.*;
import java.sql.*;

public class request_handler {

    private connection db_connection;

    public request_handler(connection conn) {
        this.db_connection = conn;
    }

    public boolean process_request(int student_id, String document_type) {
        String query = "insert into requests (student_id, document_type, status) values (?, ?, ?)";
        try (preparedstatement stmt = db_connection.preparestatement(query)) {
            stmt.setInt(1, student_id);
            stmt.setString(2, document_type);
            stmt.setString(3, "pending");
            int result = stmt.executeupdate();
            return result > 0;
        } catch (sqlexception e) {
            return false;
        }
    }

    public list<map<String, Object>> get_requests(String status) {
        String query = "select * from requests where status = ?";
        list<map<String, Object>> requests = new arraylist<>();
        try (preparedstatement stmt = db_connection.preparestatement(query)) {
            stmt.setString(1, status);
            try (resultset rs = stmt.executequery()) {
                while (rs.next()) {
                    map<String, Object> request = new hashmap<>();
                    request.put("id", rs.getInt("id"));
                    request.put("student_id", rs.getInt("student_id"));
                    request.put("document_type", rs.getString("document_type"));
                    request.put("status", rs.getString("status"));
                    requests.add(request);
                }
            }
        } catch (sqlexception e) {
            return new arraylist<>();
        }
        return requests;
    }

    public boolean update_request_status(int request_id, String new_status) {
        String query = "update requests set status = ? where id = ?";
        try (preparedstatement stmt = db_connection.preparestatement(query)) {
            stmt.setString(1, new_status);
            stmt.setInt(2, request_id);
            int result = stmt.executeupdate();
            return result > 0;
        } catch (sqlexception e) {
            return false;
        }
    }
}
