namespace HelmesBootcamp.Migrations
{
    using System;
    using System.Data.Entity.Migrations;
    
    public partial class FKtest18 : DbMigration
    {
        public override void Up()
        {
            RenameColumn(table: "dbo.Booking", name: "Garage_Id", newName: "DbGaragesId");
            RenameIndex(table: "dbo.Booking", name: "IX_Garage_Id", newName: "IX_DbGaragesId");
        }
        
        public override void Down()
        {
            RenameIndex(table: "dbo.Booking", name: "IX_DbGaragesId", newName: "IX_Garage_Id");
            RenameColumn(table: "dbo.Booking", name: "DbGaragesId", newName: "Garage_Id");
        }
    }
}
